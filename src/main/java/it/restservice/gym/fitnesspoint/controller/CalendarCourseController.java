package it.restservice.gym.fitnesspoint.controller;

import java.util.List;

import javax.ws.rs.DELETE;
import javax.ws.rs.GET;
import javax.ws.rs.POST;
import javax.ws.rs.Path;
import javax.ws.rs.PathParam;
import javax.ws.rs.Produces;
import javax.ws.rs.core.MediaType;

import com.amazonaws.services.dynamodbv2.AmazonDynamoDB;

import io.swagger.v3.oas.annotations.Operation;
import io.swagger.v3.oas.annotations.media.ArraySchema;
import io.swagger.v3.oas.annotations.media.Content;
import io.swagger.v3.oas.annotations.media.Schema;
import io.swagger.v3.oas.annotations.parameters.RequestBody;
import io.swagger.v3.oas.annotations.responses.ApiResponse;
import it.restservice.gym.fitnesspoint.auth.Authenticator;
import it.restservice.gym.fitnesspoint.dao.CalendarCourseDao;
import it.restservice.gym.fitnesspoint.entity.CalendarCourse;
import it.restservice.gym.fitnesspoint.exception.GenericRestServiceException;
import it.restservice.gym.fitnesspoint.utils.Utils;

@Path("/calendar")
@Produces(value = {MediaType.APPLICATION_JSON})
public class CalendarCourseController extends AbstractController {
	
	private CalendarCourseDao calendarDao;
	
	public CalendarCourseController(AmazonDynamoDB dynamoDBClient) {
		if(Utils.isEmpty(calendarDao))
			this.calendarDao = new CalendarCourseDao(dynamoDBClient);
	}

	@GET
	@Operation(
		summary = "Get all calendar courses",
		tags = {"Calendar"},
		description = "Returns all calendar courses",
		responses = {
			@ApiResponse(
				responseCode = "200",
				description = "List of calendar courses", 
				content = @Content(
							mediaType = MediaType.APPLICATION_JSON,
							array = @ArraySchema(
									schema = @Schema(implementation = CalendarCourse.class)
									)
							)
					),
			@ApiResponse(responseCode = "400", description = "Invalid parameters"),
			@ApiResponse(responseCode = "404", description = "Calendars not found")
	})
	public List<CalendarCourse> getCalendar() 
			throws GenericRestServiceException {
		LOG.info("getCalendarCourses");
		try {
			return calendarDao.getAll();
		} catch (Exception e) {
			LOG.error("getAll -> {}: {}", e.getClass().getSimpleName(), e.getMessage(), e);
			throw new GenericRestServiceException(parseMessage("getCalendarCourses", e), e);
		}
	}
	
	@POST
	@Authenticator
	@Operation(
		summary = "Insert or Update calendar courses",
		tags = {"Calendar"},
		description = "Insert or Updatel calendar courses",
		responses = {
			@ApiResponse(
				responseCode = "200",
				description = "Calendar inserted/updated", 
				content = @Content(
							mediaType = MediaType.APPLICATION_JSON,
							array = @ArraySchema(
									schema = @Schema(implementation = boolean.class)
									)
							)
					),
			@ApiResponse(responseCode = "400", description = "Invalid parameters"),
			@ApiResponse(responseCode = "404", description = "Calendars not found")
	})
	public boolean insertOrUpdateCalendar(
			@RequestBody(required = true, content = @Content(mediaType = MediaType.APPLICATION_JSON)) List<CalendarCourse> calendar) 
					throws GenericRestServiceException {
		LOG.info("insertOrUpdateCalendar");
		try {
			calendarDao.insertOrUpdateAll(calendar);
			return true;
		} catch (Exception e) {
			LOG.error("insertOrUpdateCalendar -> {}: {}", e.getClass().getSimpleName(), e.getMessage(), e);
			throw new GenericRestServiceException(parseMessage("insertOrUpdateCalendar", e), e);
		}
	}
	
	@DELETE
	@Path("/{time}")
	@Authenticator
	@Operation(
		summary = "Delete calendar courses",
		tags = {"Calendar"},
		description = "Delete single calendar courses by time",
		responses = {
			@ApiResponse(
				responseCode = "200",
				description = "Calendar deleted", 
				content = @Content(
							mediaType = MediaType.APPLICATION_JSON,
							array = @ArraySchema(
									schema = @Schema(implementation = boolean.class)
									)
							)
					),
			@ApiResponse(responseCode = "400", description = "Invalid parameters"),
			@ApiResponse(responseCode = "404", description = "Calendars not found")
	})
	public boolean deleteCalendar(
			@PathParam(value = "time") String time) 
					throws GenericRestServiceException {
		LOG.info("deleteCalendar");
		try {
			calendarDao.delete(time);
			return true;
		} catch (Exception e) {
			LOG.error("deleteCalendar -> {}: {}", e.getClass().getSimpleName(), e.getMessage(), e);
			throw new GenericRestServiceException(parseMessage("deleteCalendar", e), e);
		}
	}
	
	@DELETE
	@Authenticator
	@Operation(
		summary = "Delete all calendars",
		tags = {"Calendar"},
		description = "Delete all calendar courses",
		responses = {
			@ApiResponse(
				responseCode = "200",
				description = "All calendar courses deleted", 
				content = @Content(
							mediaType = MediaType.APPLICATION_JSON,
							array = @ArraySchema(
									schema = @Schema(implementation = boolean.class)
									)
							)
					),
			@ApiResponse(responseCode = "400", description = "Invalid parameters"),
			@ApiResponse(responseCode = "404", description = "Calendars not found")
	})
	public boolean deleteAllCalendar() 
			throws GenericRestServiceException {
		LOG.info("deleteAllCalendar");
		try {
			calendarDao.deleteAll();
			return true;
		} catch (Exception e) {
			LOG.error("deleteAllCalendar -> {}: {}", e.getClass().getSimpleName(), e.getMessage(), e);
			throw new GenericRestServiceException(parseMessage("deleteAllCalendar", e), e);
		}
	}
	
}
