package it.restservice.gym.fitnesspoint.controller;

import java.util.List;

import javax.ws.rs.DELETE;
import javax.ws.rs.GET;
import javax.ws.rs.POST;
import javax.ws.rs.PUT;
import javax.ws.rs.Path;
import javax.ws.rs.PathParam;
import javax.ws.rs.Produces;
import javax.ws.rs.QueryParam;
import javax.ws.rs.core.MediaType;

import com.amazonaws.services.dynamodbv2.AmazonDynamoDB;

import io.swagger.v3.oas.annotations.Operation;
import io.swagger.v3.oas.annotations.media.ArraySchema;
import io.swagger.v3.oas.annotations.media.Content;
import io.swagger.v3.oas.annotations.media.Schema;
import io.swagger.v3.oas.annotations.parameters.RequestBody;
import io.swagger.v3.oas.annotations.responses.ApiResponse;
import it.restservice.gym.fitnesspoint.auth.Authenticator;
import it.restservice.gym.fitnesspoint.dao.StaffDao;
import it.restservice.gym.fitnesspoint.entity.Staff;
import it.restservice.gym.fitnesspoint.exception.GenericRestServiceException;
import it.restservice.gym.fitnesspoint.utils.Utils;

@Path("/staff")
@Produces(value = {MediaType.APPLICATION_JSON})
public class StaffController extends AbstractController {

	private StaffDao staffDao;
	
	public StaffController(AmazonDynamoDB dynamoDBClient) {
		if(Utils.isEmpty(staffDao))
			this.staffDao = new StaffDao(dynamoDBClient);
	}

	@GET
	@Operation(
		summary = "Get Staff",
		tags = {"Staff"},
		description = "Returns all staff or staff with flag showed",
		responses = {
			@ApiResponse(
				responseCode = "200",
				description = "List of Staff", 
				content = @Content(
							mediaType = MediaType.APPLICATION_JSON,
							array = @ArraySchema(
									schema = @Schema(implementation = Staff.class)
									)
							)
					),
			@ApiResponse(responseCode = "400", description = "Invalid parameters"),
			@ApiResponse(responseCode = "404", description = "Staff not found")
	})
	public List<Staff> getStaff(
			@QueryParam(value = "flagShow") boolean flagShow) 
					throws GenericRestServiceException {
		LOG.info("getAllStaff");
		try {
			if(flagShow)
				return staffDao.getStaffByFlag(flagShow);
			else
				return staffDao.getAllStaff();
		} catch (Exception e) {
			LOG.error("getStaff -> {}: {}", e.getClass().getSimpleName(), e.getMessage(), e);
			throw new GenericRestServiceException(parseMessage("getStaff", e), e);
		}
	}
	
	@GET
	@Path("/{id}")
	@Operation(
		summary = "Get Staff by id",
		tags = {"Staff"},
		description = "Returns staff that match param id",
		responses = {
			@ApiResponse(
				responseCode = "200",
				description = "Staff", 
				content = @Content(
							mediaType = MediaType.APPLICATION_JSON,
							array = @ArraySchema(
									schema = @Schema(implementation = Staff.class)
									)
							)
					),
			@ApiResponse(responseCode = "400", description = "Invalid parameters"),
			@ApiResponse(responseCode = "404", description = "Activities not found")
	})
	public Staff getStaffByName(
			@PathParam(value = "id") String id) 
					throws GenericRestServiceException {
		LOG.info("getStaffByName --> id: {}", id);
		try {
			return staffDao.getStaffById(id);
		} catch (Exception e) {
			LOG.error("getStaffByName -> {}: {}", e.getClass().getSimpleName(), e.getMessage(), e);
			throw new GenericRestServiceException(parseMessage("getStaffByName", e), e);
		}
	}
	
	@POST
	@Path("/list")
	@Authenticator
	@Operation(
		summary = "Update Staff",
		tags = {"Staff"},
		description = "Update list of Staff",
		responses = {
			@ApiResponse(
				responseCode = "200",
				description = "Staff updated: true = Yes", 
				content = @Content(
							mediaType = MediaType.APPLICATION_JSON,
							schema = @Schema(implementation = boolean.class)
			)),
			@ApiResponse(responseCode = "400", description = "Invalid parameters"),
			@ApiResponse(responseCode = "404", description = "Staff not inserted")
	})
	public boolean updateStaffList(
			@RequestBody(required = true, content = @Content(mediaType = MediaType.APPLICATION_JSON)) List<Staff> staff) 
					throws GenericRestServiceException {
		LOG.info("updateStaffList --> staff: {}", staff.toString());
		try {
			staffDao.insertOrUpdateStaffList(staff, false);
			return true;
		} catch (Exception e) {
			LOG.error("updateStaffList -> {}: {}", e.getClass().getSimpleName(), e.getMessage(), e);
			throw new GenericRestServiceException(parseMessage("updateStaffList", e), e);
		}
	}
	
	@POST
	@Authenticator
	@Operation(
		summary = "Update Staff",
		tags = {"Staff"},
		description = "Update Staff",
		responses = {
			@ApiResponse(
				responseCode = "200",
				description = "Staff updated: true = Yes", 
				content = @Content(
							mediaType = MediaType.APPLICATION_JSON,
							schema = @Schema(implementation = boolean.class)
			)),
			@ApiResponse(responseCode = "400", description = "Invalid parameters"),
			@ApiResponse(responseCode = "404", description = "Activities not inserted")
	})
	public boolean updateStaff(
			@RequestBody(required = true, content = @Content(mediaType = MediaType.APPLICATION_JSON)) Staff staff) 
					throws GenericRestServiceException {
		LOG.info("updateStaff --> staff: {}", staff.toString());
		try {
			staffDao.insertOrUpdateStaff(staff, false);
			return true;
		} catch (Exception e) {
			LOG.error("updateStaff -> {}: {}", e.getClass().getSimpleName(), e.getMessage(), e);
			throw new GenericRestServiceException(parseMessage("updateStaff", e), e);
		}
	}
	
	@PUT
	@Path("/list")
	@Authenticator
	@Operation(
		summary = "Insert Staff",
		tags = {"Staff"},
		description = "Insert list of Staff",
		responses = {
			@ApiResponse(
				responseCode = "200",
				description = "Staff inserted: true = Yes", 
				content = @Content(
							mediaType = MediaType.APPLICATION_JSON,
							schema = @Schema(implementation = boolean.class)
			)),
			@ApiResponse(responseCode = "400", description = "Invalid parameters"),
			@ApiResponse(responseCode = "404", description = "Staff not inserted")
	})
	public boolean insertStaffList(
			@RequestBody(required = true, content = @Content(mediaType = MediaType.APPLICATION_JSON)) List<Staff> staff) 
					throws GenericRestServiceException {
		LOG.info("insertStaffList --> staff: {}", staff.toString());
		try {
			staffDao.insertOrUpdateStaffList(staff, true);
			return true;
		} catch (Exception e) {
			LOG.error("insertStaffList -> {}: {}", e.getClass().getSimpleName(), e.getMessage(), e);
			throw new GenericRestServiceException(parseMessage("insertStaffList", e), e);
		}
	}
	
	@PUT
	@Authenticator
	@Operation(
		summary = "Insert Staff",
		tags = {"Staff"},
		description = "Insert Staff",
		responses = {
			@ApiResponse(
				responseCode = "200",
				description = "Staff inserted: true = Yes", 
				content = @Content(
							mediaType = MediaType.APPLICATION_JSON,
							schema = @Schema(implementation = boolean.class)
			)),
			@ApiResponse(responseCode = "400", description = "Invalid parameters"),
			@ApiResponse(responseCode = "404", description = "Activities not inserted")
	})
	public boolean insertStaff(
			@RequestBody(required = true, content = @Content(mediaType = MediaType.APPLICATION_JSON)) Staff staff) 
					throws GenericRestServiceException {
		LOG.info("insertStaff --> staff: {}", staff.toString());
		try {
			staffDao.insertOrUpdateStaff(staff, true);
			return true;
		} catch (Exception e) {
			LOG.error("insertStaff -> {}: {}", e.getClass().getSimpleName(), e.getMessage(), e);
			throw new GenericRestServiceException(parseMessage("insertStaff", e), e);
		}
	}
	
	@DELETE
	@Path("/list")
	@Operation(
		summary = "Delete All Staff",
		tags = {"Staff"},
		description = "Delete All Staff",
		responses = {
			@ApiResponse(
				responseCode = "200",
				description = "All Staff deleted: true = Yes", 
				content = @Content(
							mediaType = MediaType.APPLICATION_JSON,
							schema = @Schema(implementation = boolean.class)
			)),
			@ApiResponse(responseCode = "400", description = "Invalid parameters"),
			@ApiResponse(responseCode = "404", description = "Activities not deleted")
	})
	public boolean deleteAllStaff() 
			throws Exception {
		LOG.info("deleteAllStaff");
		try {
			staffDao.deleteAllStaff();
			return true;
		} catch (Exception e) {
			LOG.error("deleteAllStaff -> {}: {}", e.getClass().getSimpleName(), e.getMessage(), e);
			throw e;
		}
	}
	
	@DELETE
	@Path("/{id}")
	@Authenticator
	@Operation(
		summary = "Delete Staff",
		tags = {"Staff"},
		description = "Delete Staff",
		responses = {
			@ApiResponse(
				responseCode = "200",
				description = "Staff deleted: true = Yes", 
				content = @Content(
							mediaType = MediaType.APPLICATION_JSON,
							schema = @Schema(implementation = boolean.class)
			)),
			@ApiResponse(responseCode = "400", description = "Invalid parameters"),
			@ApiResponse(responseCode = "404", description = "Activities not deleted")
	})
	public boolean deleteStaff(
			@PathParam(value = "id") String id) 
					throws GenericRestServiceException {
		LOG.info("deleteStaff --> id: {}", id);
		try {
			staffDao.deleteStaff(id);
			return true;
		} catch (Exception e) {
			LOG.error("deleteStaff -> {}: {}", e.getClass().getSimpleName(), e.getMessage(), e);
			throw new GenericRestServiceException(parseMessage("deleteStaff", e), e);
		}
	}
	
}
