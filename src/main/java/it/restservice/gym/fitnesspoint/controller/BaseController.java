package it.restservice.gym.fitnesspoint.controller;

import java.util.List;

import javax.ws.rs.GET;
import javax.ws.rs.Path;
import javax.ws.rs.Produces;
import javax.ws.rs.QueryParam;
import javax.ws.rs.core.MediaType;

import com.amazonaws.services.dynamodbv2.AmazonDynamoDB;

import io.swagger.v3.oas.annotations.Operation;
import io.swagger.v3.oas.annotations.media.ArraySchema;
import io.swagger.v3.oas.annotations.media.Content;
import io.swagger.v3.oas.annotations.media.Schema;
import io.swagger.v3.oas.annotations.responses.ApiResponse;
import it.restservice.gym.fitnesspoint.auth.JWTAuthenticator;
import it.restservice.gym.fitnesspoint.dao.BaseDao;
import it.restservice.gym.fitnesspoint.entity.User;
import it.restservice.gym.fitnesspoint.exception.GenericRestServiceException;
import it.restservice.gym.fitnesspoint.utils.Utils;

@Path("/")
@Produces(value = {MediaType.APPLICATION_JSON})
public class BaseController extends AbstractController {
	
	private BaseDao dao;
	
	private String rsaJWT;
	
	public BaseController(AmazonDynamoDB dynamoDBClient, String rsaJWT) {
		if(Utils.isEmpty(dao))
			this.dao = new BaseDao(dynamoDBClient);
		
		this.rsaJWT = rsaJWT;
	}
	
	@GET
	@Path("/tables")
	@Operation(
		summary = "Get list of table",
		tags = {"info"},
		description = "Returns list of table",
		responses = {
			@ApiResponse(
				responseCode = "200",
				description = "List of table", 
				content = @Content(
							mediaType = MediaType.APPLICATION_JSON,
							array = @ArraySchema(
										schema =  @Schema(implementation = String.class)
									)
							)
					),
			@ApiResponse(responseCode = "400", description = "Invalid parameters"),
			@ApiResponse(responseCode = "404", description = "Calendars not found")
	})
	public List<String> getTables() 
			throws GenericRestServiceException {
		LOG.info("getTables");
		try {
			return dao.getAllTables();
		} catch (Exception e) {
			LOG.error("getTables -> {}: {}", e.getClass().getSimpleName(), e.getMessage(), e);
			throw new GenericRestServiceException(parseMessage("getTables", e), e);
		}
	}
	
	@GET
	@Path("/login")
	@Operation(
		summary = "Login",
		tags = {"Authentication"},
		description = "Returns logged user data",
		responses = {
			@ApiResponse(
				responseCode = "200",
				description = "User data", 
				content = @Content(
							mediaType = MediaType.APPLICATION_JSON,
							schema =  @Schema(implementation = User.class)
							)
					),
			@ApiResponse(responseCode = "400", description = "Invalid parameters"),
			@ApiResponse(responseCode = "404", description = "Calendars not found")
	})
	public User login(
			@QueryParam(value = "username") String  username, 
			@QueryParam(value = "password") String password) 
					throws GenericRestServiceException {
		LOG.info("login");
		try {
			User user = dao.login(username, password);
			
			if(Utils.isEmpty(user))
				return null;
			
			JWTAuthenticator auth = new JWTAuthenticator(rsaJWT);
			String token = auth.generateJWT();
			
			user.setToken(token);
			
			return user;
		} catch (Exception e) {
			LOG.error("login -> {}: {}", e.getClass().getSimpleName(), e.getMessage(), e);
			throw new GenericRestServiceException(parseMessage("login", e), e);
		}
	}
	
}
