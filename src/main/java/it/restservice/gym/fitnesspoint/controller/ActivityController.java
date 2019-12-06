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
import it.restservice.gym.fitnesspoint.dao.ActivityDao;
import it.restservice.gym.fitnesspoint.entity.Activity;
import it.restservice.gym.fitnesspoint.exception.GenericRestServiceException;
import it.restservice.gym.fitnesspoint.utils.Utils;

@Path("/activity")
@Produces(value = {MediaType.APPLICATION_JSON})
public class ActivityController extends AbstractController {
	
	private ActivityDao activityDao;
	
	public ActivityController(AmazonDynamoDB dynamoDBClient) {
		if(Utils.isEmpty(activityDao))
			this.activityDao = new ActivityDao(dynamoDBClient);
	}

	@GET
	@Operation(
		summary = "Get Activities",
		tags = {"Activity"},
		description = "Returns all activities or activities with flag showed",
		responses = {
			@ApiResponse(
				responseCode = "200",
				description = "List of Activities", 
				content = @Content(
							mediaType = MediaType.APPLICATION_JSON,
							array = @ArraySchema(
									schema = @Schema(implementation = Activity.class)
									)
							)
					),
			@ApiResponse(responseCode = "400", description = "Invalid parameters"),
			@ApiResponse(responseCode = "404", description = "Activities not found")
	})
	public List<Activity> getActivities(
			@QueryParam(value = "flagShow") boolean flagShow) 
					throws GenericRestServiceException {
		LOG.info("getActivities");
		try {
			if(flagShow)
				return activityDao.getActivitiesByFlag(flagShow);
			else
				return activityDao.getAllActivities();
		} catch (Exception e) {
			LOG.error("getActivities -> {}: {}", e.getClass().getSimpleName(), e.getMessage(), e);
			throw new GenericRestServiceException(parseMessage("getAllActivities", e), e);
		}
	}
	
	@GET
	@Path("/{name}")
	@Operation(
		summary = "Get Activities by name",
		tags = {"Activity"},
		description = "Returns activity by name",
		responses = {
			@ApiResponse(
				responseCode = "200",
				description = "Activity", 
				content = @Content(
							mediaType = MediaType.APPLICATION_JSON,
							schema = @Schema(implementation = Activity.class)
							)
					),
			@ApiResponse(responseCode = "400", description = "Invalid parameters"),
			@ApiResponse(responseCode = "404", description = "Activities not found")
	})
	public Activity getActivityByName(
			@PathParam(value = "name") String name)
					throws GenericRestServiceException {
		LOG.info("getActivityById --> name: {}", name);
		try {
//			return new Activity("name", "description", "/img", "url", new Date(), 0);
			return activityDao.getActivityByName(name);
		} catch (Exception e) {
			LOG.error("getActivityById -> {}: {}", e.getClass().getSimpleName(), e.getMessage(), e);
			throw new GenericRestServiceException(parseMessage("getActivityById", e), e);
		}
	}
	
	@POST
	@Path("/list")
	@Authenticator
	@Operation(
		summary = "Update Activities",
		tags = {"Activity"},
		description = "Update All ctivity",
		responses = {
			@ApiResponse(
				responseCode = "200",
				description = "Update All Activity: true Yes", 
				content = @Content(
							mediaType = MediaType.APPLICATION_JSON,
							schema = @Schema(implementation = boolean.class)
			)),
			@ApiResponse(responseCode = "400", description = "Invalid parameters"),
			@ApiResponse(responseCode = "404", description = "Activities not updated")
	})
	public boolean updateActivities(
			@RequestBody(required = true, content = @Content(mediaType = MediaType.APPLICATION_JSON)) List<Activity> activities) 
					throws GenericRestServiceException {
		LOG.info("updateActivities --> activities: {}", activities.toString());
		try {
			activityDao.insertOrUpdateActivities(activities, false);
			return true;
		} catch (Exception e) {
			LOG.error("updateActivities -> {}: {}", e.getClass().getSimpleName(), e.getMessage(), e);
			throw new GenericRestServiceException(parseMessage("updateActivities", e), e);
		}
	}
	
	@POST
	@Authenticator
	@Operation(
		summary = "Update Activity",
		tags = {"Activity"},
		description = "Update Activity",
		responses = {
			@ApiResponse(
				responseCode = "200",
				description = "Update Activity: true Yes", 
				content = @Content(
							mediaType = MediaType.APPLICATION_JSON,
							schema = @Schema(implementation = boolean.class)
			)),
			@ApiResponse(responseCode = "400", description = "Invalid parameters"),
			@ApiResponse(responseCode = "404", description = "Activity not updated")
	})
	public boolean updateActivity(
			@RequestBody(required = true, content = @Content(mediaType = MediaType.APPLICATION_JSON)) Activity activity) 
					throws GenericRestServiceException {
		LOG.info("updateActivity --> activity: {}", activity.toString());
		try {
			activityDao.insertOrUpdateActivity(activity, false);
			return true;
		} catch (Exception e) {
			LOG.error("updateActivity -> {}: {}", e.getClass().getSimpleName(), e.getMessage(), e);
			throw new GenericRestServiceException(parseMessage("updateActivity", e), e);
		}
	}
	
	@PUT
	@Path("/list")
	@Authenticator
	@Operation(
		summary = "Insert Activities",
		tags = {"Activity"},
		description = "Insert Activities",
		responses = {
			@ApiResponse(
				responseCode = "200",
				description = "Activities inserted: true Yes", 
				content = @Content(
							mediaType = MediaType.APPLICATION_JSON,
							schema = @Schema(implementation = boolean.class)
			)),
			@ApiResponse(responseCode = "400", description = "Invalid parameters"),
			@ApiResponse(responseCode = "404", description = "Activities not inserted")
	})
	public boolean insertActivities(
			@RequestBody(required = true, content = @Content(mediaType = MediaType.APPLICATION_JSON)) List<Activity> activities) 
					throws GenericRestServiceException {
		LOG.info("insertActivities --> activities: {}", activities.toString());
		try {
			activityDao.insertOrUpdateActivities(activities, true);
			return true;
		} catch (Exception e) {
			LOG.error("insertActivities -> {}: {}", e.getClass().getSimpleName(), e.getMessage(), e);
			throw new GenericRestServiceException(parseMessage("insertActivities", e), e);
		}
	}
	
	@PUT
	@Authenticator
	@Operation(
		summary = "Insert Activity",
		tags = {"Activity"},
		description = "Insert Activity",
		responses = {
			@ApiResponse(
				responseCode = "200",
				description = "Activity inserted: true Yes", 
				content = @Content(
							mediaType = MediaType.APPLICATION_JSON,
							schema = @Schema(implementation = boolean.class)
			)),
			@ApiResponse(responseCode = "400", description = "Invalid parameters"),
			@ApiResponse(responseCode = "404", description = "Activities not inserted")
	})
	public boolean insertActivity(
			@RequestBody(required = true, content = @Content(mediaType = MediaType.APPLICATION_JSON)) Activity activity) 
					throws GenericRestServiceException {
		LOG.info("insertActivity --> activity: {}", activity.toString());
		try {
			activityDao.insertOrUpdateActivity(activity, true);
			return true;
		} catch (Exception e) {
			LOG.error("insertActivity -> {}: {}", e.getClass().getSimpleName(), e.getMessage(), e);
			throw new GenericRestServiceException(parseMessage("insertActivity", e), e);
		}
	}
	
	@DELETE
	@Path("/list")
	@Authenticator
	@Operation(
		summary = "Delete All Activities",
		tags = {"Activity"},
		description = "Delete All Activities",
		responses = {
			@ApiResponse(
				responseCode = "200",
				description = "All Activities deleted: true Yes", 
				content = @Content(
							mediaType = MediaType.APPLICATION_JSON,
							schema = @Schema(implementation = boolean.class)
			)),
			@ApiResponse(responseCode = "400", description = "Invalid parameters"),
			@ApiResponse(responseCode = "404", description = "Activities not deleted")
	})
	public boolean deleteAllActivities() 
			throws GenericRestServiceException {
		LOG.info("deleteAllActivities");
		try {
			activityDao.deleteAllActivities();
			return true;
		} catch (Exception e) {
			LOG.error("deleteAllActivities -> {}: {}", e.getClass().getSimpleName(), e.getMessage(), e);
			throw new GenericRestServiceException(parseMessage("deleteAllActivities", e), e);
		}
	}
	
	@DELETE
	@Path("/{name}")
	@Authenticator
	@Operation(
		summary = "Delete Activity",
		tags = {"Activity"},
		description = "Delete Activity",
		responses = {
			@ApiResponse(
				responseCode = "200",
				description = "Activity deteled: true Yes", 
				content = @Content(
							mediaType = MediaType.APPLICATION_JSON,
							schema = @Schema(implementation = boolean.class)
			)),
			@ApiResponse(responseCode = "400", description = "Invalid parameters"),
			@ApiResponse(responseCode = "404", description = "Activities not deleted")
	})
	public boolean deleteActivity(
			@PathParam(value = "name") String name) 
					throws GenericRestServiceException {
		LOG.info("deleteActivity --> name: {}", name);
		try {
			activityDao.deleteActivity(name);
			return true;
		} catch (Exception e) {
			LOG.error("deleteActivity -> {}: {}", e.getClass().getSimpleName(), e.getMessage(), e);
			throw new GenericRestServiceException(parseMessage("deleteActivity", e), e);
		}
	}
	
}
