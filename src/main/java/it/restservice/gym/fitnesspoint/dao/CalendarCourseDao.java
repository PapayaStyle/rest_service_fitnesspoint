package it.restservice.gym.fitnesspoint.dao;

import java.util.List;

import com.amazonaws.services.dynamodbv2.AmazonDynamoDB;
import com.amazonaws.services.dynamodbv2.datamodeling.DynamoDBScanExpression;

import it.restservice.gym.fitnesspoint.entity.CalendarCourse;

public class CalendarCourseDao extends AbstractDao {
	
	public CalendarCourseDao(AmazonDynamoDB dynamoClient) {
		initDynamoDB(dynamoClient);
	}

	/**
	 * Get all Calendar Courses data
	 * @return List<CalendarCourse>
	 */
	public List<CalendarCourse> getAll() {
		LOG.info("getAll");
		return dynamoMapper.scan(CalendarCourse.class, new DynamoDBScanExpression());
	}
	
	/**
	 * Insert or Update all Calendar Courses
	 * @param courses
	 */
	public void insertOrUpdateAll(List<CalendarCourse> courses) {
		LOG.info("insertAll");
		for(CalendarCourse course: courses) {
			insertOrUpdate(course);
		}
	}
	
	/**
	 * Insert or Update Calendar Course
	 * @param course
	 */
	public void insertOrUpdate(CalendarCourse course) {
		LOG.info("insert");
		dynamoMapper.save(course);
	}
	
	/**
	 * Delete All Calendar Courses
	 */
	public void deleteAll() {
		LOG.info("deleteAll");
		List<CalendarCourse> courses = getAll();
		for(CalendarCourse course: courses) {
			delete(course);
		}
	}
	
	/**
	 * Delete Calendar Course
	 * @param calendar
	 */
	public void delete(CalendarCourse calendar) {
		LOG.info("delete");
		dynamoMapper.delete(calendar);
	}
	
	/**
	 * Delete Calendar Course
	 * @param time
	 */
	public void delete(String time) {
		LOG.info("delete");
		CalendarCourse calendar = new CalendarCourse(time);
		dynamoMapper.delete(calendar);
	}
	
}
