package it.restservice.gym.fitnesspoint.controller;

import java.util.ArrayList;
import java.util.Comparator;
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
import it.restservice.gym.fitnesspoint.dao.NewsDao;
import it.restservice.gym.fitnesspoint.entity.News;
import it.restservice.gym.fitnesspoint.exception.GenericRestServiceException;
import it.restservice.gym.fitnesspoint.utils.Utils;

@Path("/news")
@Produces(value = {MediaType.APPLICATION_JSON})
public class NewsController extends AbstractController {

	private NewsDao newsDao;
	
	public NewsController(AmazonDynamoDB dynamoDBClient) {
		if(Utils.isEmpty(newsDao))
			this.newsDao = new NewsDao(dynamoDBClient);
	}
	
	@GET
	@Operation(
		summary = "Get News",
		tags = {"News"},
		description = "Returns all news or news with flag showed",
		responses = {
			@ApiResponse(
				responseCode = "200",
				description = "List of News", 
				content = @Content(
							mediaType = MediaType.APPLICATION_JSON,
							array = @ArraySchema(
									schema = @Schema(implementation = News.class)
									)
							)
					),
			@ApiResponse(responseCode = "400", description = "Invalid parameters"),
			@ApiResponse(responseCode = "404", description = "News not found")
	})
	public List<News> getNews(
			@QueryParam(value = "flagShow") boolean flagShow,
			@QueryParam(value = "flagLast") boolean flagLast) 
					throws GenericRestServiceException {
		LOG.info("getAllNews");
		try {
			if(flagShow) {
				List<News> result = newsDao.getNewsByFlag(flagShow);
				
				if(flagLast && Utils.isNotEmpty(result)) {
					result.sort(new Comparator<News>() {
						@Override
						public int compare(News n1, News n2) {
							if (n1.getDate() == null && n2.getDate() != null) 
								return -1;
							if (n1.getDate() != null && n2.getDate() == null) 
								return 1;
							return n1.getDate().compareTo(n2.getDate());
						}
					});
					
					List<News> res = new ArrayList<News>();
					result.forEach( news -> {
						if(res.size() < 2)
							res.add(news);
					});
					return res;
				}
				return result;
			} else
				return newsDao.getAllNews();
		} catch (Exception e) {
			LOG.error("getNews -> {}: {}", e.getClass().getSimpleName(), e.getMessage(), e);
			throw new GenericRestServiceException(parseMessage("getNews", e), e);
		}
	}
	
	@GET
	@Path("/{id}")
	@Operation(
		summary = "Get News by id",
		tags = {"News"},
		description = "Returns news that match param id",
		responses = {
			@ApiResponse(
				responseCode = "200",
				description = "News", 
				content = @Content(
							mediaType = MediaType.APPLICATION_JSON,
							array = @ArraySchema(
									schema = @Schema(implementation = News.class)
									)
							)
					),
			@ApiResponse(responseCode = "400", description = "Invalid parameters"),
			@ApiResponse(responseCode = "404", description = "Activities not found")
	})
	public News getNewsByName(
			@PathParam(value = "id") String id) 
					throws GenericRestServiceException {
		LOG.info("getNewsByName --> id: {}", id);
		try {
			return newsDao.getNewsById(id);
		} catch (Exception e) {
			LOG.error("getNewsByName -> {}: {}", e.getClass().getSimpleName(), e.getMessage(), e);
			throw new GenericRestServiceException(parseMessage("getNewsByName", e), e);
		}
	}
	
	@POST
	@Path("/list")
	@Authenticator
	@Operation(
		summary = "Update News",
		tags = {"News"},
		description = "Update list of News",
		responses = {
			@ApiResponse(
				responseCode = "200",
				description = "News updated: true = Yes", 
				content = @Content(
							mediaType = MediaType.APPLICATION_JSON,
							schema = @Schema(implementation = boolean.class)
			)),
			@ApiResponse(responseCode = "400", description = "Invalid parameters"),
			@ApiResponse(responseCode = "404", description = "News not inserted")
	})
	public boolean updateNewsList(
			@RequestBody(required = true, content = @Content(mediaType = MediaType.APPLICATION_JSON)) List<News> news) 
					throws GenericRestServiceException {
		LOG.info("updateNewsList --> news: {}", news.toString());
		try {
			newsDao.insertOrUpdateNewsList(news, false);
			return true;
		} catch (Exception e) {
			LOG.error("updateNewsList -> {}: {}", e.getClass().getSimpleName(), e.getMessage(), e);
			throw new GenericRestServiceException(parseMessage("updateNewsList", e), e);
		}
	}
	
	@POST
	@Authenticator
	@Operation(
		summary = "Update News",
		tags = {"News"},
		description = "Update News",
		responses = {
			@ApiResponse(
				responseCode = "200",
				description = "News updated: true = Yes", 
				content = @Content(
							mediaType = MediaType.APPLICATION_JSON,
							schema = @Schema(implementation = boolean.class)
			)),
			@ApiResponse(responseCode = "400", description = "Invalid parameters"),
			@ApiResponse(responseCode = "404", description = "Activities not inserted")
	})
	public boolean updateNews(
			@RequestBody(required = true, content = @Content(mediaType = MediaType.APPLICATION_JSON)) News news) 
					throws GenericRestServiceException {
		LOG.info("updateNews --> news: {}", news.toString());
		try {
			newsDao.insertOrUpdateNews(news, false);
			return true;
		} catch (Exception e) {
			LOG.error("updateNews -> {}: {}", e.getClass().getSimpleName(), e.getMessage(), e);
			throw new GenericRestServiceException(parseMessage("updateNews", e), e);
		}
	}
	
	@PUT
	@Path("/list")
	@Authenticator
	@Operation(
		summary = "Insert News",
		tags = {"News"},
		description = "Insert list of News",
		responses = {
			@ApiResponse(
				responseCode = "200",
				description = "News inserted: true = Yes", 
				content = @Content(
							mediaType = MediaType.APPLICATION_JSON,
							schema = @Schema(implementation = boolean.class)
			)),
			@ApiResponse(responseCode = "400", description = "Invalid parameters"),
			@ApiResponse(responseCode = "404", description = "News not inserted")
	})
	public boolean insertNewsList(
			@RequestBody(required = true, content = @Content(mediaType = MediaType.APPLICATION_JSON)) List<News> news) 
					throws GenericRestServiceException {
		LOG.info("insertNewsList --> news: {}", news.toString());
		try {
			newsDao.insertOrUpdateNewsList(news, true);
			return true;
		} catch (Exception e) {
			LOG.error("insertNewsList -> {}: {}", e.getClass().getSimpleName(), e.getMessage(), e);
			throw new GenericRestServiceException(parseMessage("insertNewsList", e), e);
		}
	}
	
	@PUT
	@Authenticator
	@Operation(
		summary = "Insert News",
		tags = {"News"},
		description = "Insert News",
		responses = {
			@ApiResponse(
				responseCode = "200",
				description = "News inserted: true = Yes", 
				content = @Content(
							mediaType = MediaType.APPLICATION_JSON,
							schema = @Schema(implementation = boolean.class)
			)),
			@ApiResponse(responseCode = "400", description = "Invalid parameters"),
			@ApiResponse(responseCode = "404", description = "Activities not inserted")
	})
	public boolean insertNews(
			@RequestBody(required = true, content = @Content(mediaType = MediaType.APPLICATION_JSON)) News news) 
					throws GenericRestServiceException {
		LOG.info("insertNews --> news: {}", news.toString());
		try {
			newsDao.insertOrUpdateNews(news, true);
			return true;
		} catch (Exception e) {
			LOG.error("insertNews -> {}: {}", e.getClass().getSimpleName(), e.getMessage(), e);
			throw new GenericRestServiceException(parseMessage("insertNews", e), e);
		}
	}
	
	@DELETE
	@Path("/list")
	@Operation(
		summary = "Delete All News",
		tags = {"News"},
		description = "Delete All News",
		responses = {
			@ApiResponse(
				responseCode = "200",
				description = "All News deleted: true = Yes", 
				content = @Content(
							mediaType = MediaType.APPLICATION_JSON,
							schema = @Schema(implementation = boolean.class)
			)),
			@ApiResponse(responseCode = "400", description = "Invalid parameters"),
			@ApiResponse(responseCode = "404", description = "Activities not deleted")
	})
	public boolean deleteAllNews() 
			throws Exception {
		LOG.info("deleteAllNews");
		try {
			newsDao.deleteAllNews();
			return true;
		} catch (Exception e) {
			LOG.error("deleteAllNews -> {}: {}", e.getClass().getSimpleName(), e.getMessage(), e);
			throw e;
		}
	}
	
	@DELETE
	@Path("/{id}")
	@Authenticator
	@Operation(
		summary = "Delete News",
		tags = {"News"},
		description = "Delete News",
		responses = {
			@ApiResponse(
				responseCode = "200",
				description = "News deleted: true = Yes", 
				content = @Content(
							mediaType = MediaType.APPLICATION_JSON,
							schema = @Schema(implementation = boolean.class)
			)),
			@ApiResponse(responseCode = "400", description = "Invalid parameters"),
			@ApiResponse(responseCode = "404", description = "Activities not deleted")
	})
	public boolean deleteNews(
			@PathParam(value = "id") String id) 
					throws GenericRestServiceException {
		LOG.info("deleteNews --> id: {}", id);
		try {
			newsDao.deleteNews(id);
			return true;
		} catch (Exception e) {
			LOG.error("deleteNews -> {}: {}", e.getClass().getSimpleName(), e.getMessage(), e);
			throw new GenericRestServiceException(parseMessage("deleteNews", e), e);
		}
	}
	
}
