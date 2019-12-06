package it.restservice.gym.fitnesspoint.dao;

import java.util.Collections;
import java.util.Date;
import java.util.List;

import com.amazonaws.services.dynamodbv2.AmazonDynamoDB;
import com.amazonaws.services.dynamodbv2.datamodeling.DynamoDBScanExpression;
import com.amazonaws.services.dynamodbv2.model.AttributeValue;

import it.restservice.gym.fitnesspoint.entity.Activity;

public class ActivityDao extends AbstractDao {

	public ActivityDao(AmazonDynamoDB dynamoClient) {
		initDynamoDB(dynamoClient);
	}

	/**
	 * Get All Activities
	 * @return List<Activity>
	 */
	public List<Activity> getAllActivities() {
		LOG.info("getAllActivities");	
		return dynamoMapper.scan(Activity.class, new DynamoDBScanExpression());
	}
	
	/**
	 * Get Activities By Flag Showed
	 * @param flagAll
	 * @return List<Activity>
	 */
	public List<Activity> getActivitiesByFlag(Boolean flagShow) {
		LOG.info("getActivitiesByFlag");		
		DynamoDBScanExpression scanExpression = new DynamoDBScanExpression()
				.withFilterExpression("#key = :value")
				.withExpressionAttributeNames(Collections.singletonMap("#key", "showed"))
				.withExpressionAttributeValues(
						Collections.singletonMap(":value", new AttributeValue().withBOOL(flagShow)));

		return dynamoMapper.scan(Activity.class, scanExpression);
	}
	
	/**
	 * Get Activity By Name
	 * @param name
	 * @return Activity
	 */
	public Activity getActivityByName(String name) {
		LOG.info("getActivityByName");
		return dynamoMapper.load(Activity.class, name);
	}
	
	
	/**
	 * insert or Update Activities list
	 * @param activities
	 * @param insert
	 */
	public void insertOrUpdateActivities(List<Activity> activities, boolean insert) {
		LOG.info("insertOrUpdateActivities");
		activities.forEach( activity -> {
			insertOrUpdateActivity(activity, insert);
		});
	}
	
	/**
	 * insert or Update single Activity
	 * @param activity
	 * @param insert
	 */
	public void insertOrUpdateActivity(Activity activity, boolean insert) {
		if(insert) {
			LOG.info("insertActivity");
			activity.setDateIns(new Date().getTime());
		} else
			LOG.info("updateActivity");
		
		dynamoMapper.save(activity);
	}

	/**
	 *  Delete All Activities
	 */
	public void deleteAllActivities() {
		LOG.info("deleteAllActivities");
		List<Activity> activities = getAllActivities();
		activities.forEach( activity -> {
			deleteActivity(activity);
		});
	}
	
	/**
	 * Delete Activity
	 * @param activity
	 */
	public void deleteActivity(Activity activity) {
		LOG.info("deleteActivity");		
		dynamoMapper.delete(activity);
	}
	
	/**
	 * Delete Activity
	 * @param name
	 */
	public void deleteActivity(String name) {
		LOG.info("deleteActivity");
		Activity activity = new Activity(name);
		dynamoMapper.delete(activity);
	}

}
