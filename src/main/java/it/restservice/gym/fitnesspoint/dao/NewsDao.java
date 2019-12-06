package it.restservice.gym.fitnesspoint.dao;

import java.util.Collections;
import java.util.Date;
import java.util.List;

import com.amazonaws.services.dynamodbv2.AmazonDynamoDB;
import com.amazonaws.services.dynamodbv2.datamodeling.DynamoDBScanExpression;
import com.amazonaws.services.dynamodbv2.model.AttributeValue;

import it.restservice.gym.fitnesspoint.entity.News;

public class NewsDao extends AbstractDao {

	public NewsDao(AmazonDynamoDB dynamoClient) {
		initDynamoDB(dynamoClient);
	}
	
	/**
	 * Get All News
	 * @return List<Staff>
	 */
	public List<News> getAllNews() {
		LOG.info("getAllNews");	
		return dynamoMapper.scan(News.class, new DynamoDBScanExpression());
	}
	
	/**
	 * Get News By Flag Showed
	 * @param flagAll
	 * @return List<News>
	 */
	public List<News> getNewsByFlag(Boolean flagShow) {
		LOG.info("getNewsByFlag");		
		DynamoDBScanExpression scanExpression = new DynamoDBScanExpression()
				.withFilterExpression("#key = :value")
				.withExpressionAttributeNames(Collections.singletonMap("#key", "showed"))
				.withExpressionAttributeValues(
						Collections.singletonMap(":value", new AttributeValue().withBOOL(flagShow)));

		return dynamoMapper.scan(News.class, scanExpression);
	}
	
	/**
	 * Get News By Id
	 * @param id
	 * @return News
	 */
	public News getNewsById(String id) {
		LOG.info("getNewsById");
		return dynamoMapper.load(News.class, id);
	}
	
	/**
	 * insert or Update News list
	 * @param activities
	 * @param insert
	 */
	public void insertOrUpdateNewsList(List<News> list, boolean insert) {
		LOG.info("insertOrUpdateNewsList");
		list.forEach( news -> {
			insertOrUpdateNews(news, insert);
		});
	}
	
	/**
	 * insert or Update single News
	 * @param staff
	 * @param insert
	 */
	public void insertOrUpdateNews(News news, boolean insert) {
		if(insert) {
			LOG.info("insertNews");
			news.setDateIns(new Date().getTime());
		} else
			LOG.info("updateNews");
		
		dynamoMapper.save(news);
	}
	
	/**
	 *  Delete All News
	 */
	public void deleteAllNews() {
		LOG.info("deleteAllNews");
		List<News> list = getAllNews();
		list.forEach( staff -> {
			deleteNews(staff);
		});
	}
	
	/**
	 * Delete News
	 * @param activity
	 */
	public void deleteNews(News news) {
		LOG.info("deleteNews");		
		dynamoMapper.delete(news);
	}
	
	/**
	 * Delete News
	 * @param name
	 */
	public void deleteNews(String id) {
		LOG.info("deleteNews");
		News staff = new News(id);
		dynamoMapper.delete(staff);
	}
	
}
