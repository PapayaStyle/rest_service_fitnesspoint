package it.restservice.gym.fitnesspoint.dao;

import java.util.Collections;
import java.util.Date;
import java.util.List;

import com.amazonaws.services.dynamodbv2.AmazonDynamoDB;
import com.amazonaws.services.dynamodbv2.datamodeling.DynamoDBScanExpression;
import com.amazonaws.services.dynamodbv2.model.AttributeValue;

import it.restservice.gym.fitnesspoint.entity.Staff;

public class StaffDao extends AbstractDao {

	public StaffDao(AmazonDynamoDB dynamoClient) {
		initDynamoDB(dynamoClient);
	}

	/**
	 * Get All Staff
	 * @return List<Staff>
	 */
	public List<Staff> getAllStaff() {
		LOG.info("getAllStaff");	
		return dynamoMapper.scan(Staff.class, new DynamoDBScanExpression());
	}
	
	/**
	 * Get Staff By Flag Showed
	 * @param flagAll
	 * @return List<Staff>
	 */
	public List<Staff> getStaffByFlag(Boolean flagShow) {
		LOG.info("getStaffByFlag");		
		DynamoDBScanExpression scanExpression = new DynamoDBScanExpression()
				.withFilterExpression("#key = :value")
				.withExpressionAttributeNames(Collections.singletonMap("#key", "showed"))
				.withExpressionAttributeValues(
						Collections.singletonMap(":value", new AttributeValue().withBOOL(flagShow)));

		return dynamoMapper.scan(Staff.class, scanExpression);
	}
	
	/**
	 * Get Staff By Id
	 * @param id
	 * @return Staff
	 */
	public Staff getStaffById(String id) {
		LOG.info("getStaffById");
		return dynamoMapper.load(Staff.class, id);
	}
	
	
	/**
	 * insert or Update Staff list
	 * @param activities
	 * @param insert
	 */
	public void insertOrUpdateStaffList(List<Staff> list, boolean insert) {
		LOG.info("insertOrUpdateStaffList");
		list.forEach( staff -> {
			insertOrUpdateStaff(staff, insert);
		});
	}
	
	/**
	 * insert or Update single Staff
	 * @param staff
	 * @param insert
	 */
	public void insertOrUpdateStaff(Staff staff, boolean insert) {
		if(insert) {
			LOG.info("insertStaff");
			staff.setDateIns(new Date().getTime());
		} else
			LOG.info("updateStaff");
		
		dynamoMapper.save(staff);
	}

	/**
	 *  Delete All Staff
	 */
	public void deleteAllStaff() {
		LOG.info("deleteAllStaff");
		List<Staff> list = getAllStaff();
		list.forEach( staff -> {
			deleteStaff(staff);
		});
	}
	
	/**
	 * Delete Staff
	 * @param activity
	 */
	public void deleteStaff(Staff staff) {
		LOG.info("deleteStaff");		
		dynamoMapper.delete(staff);
	}
	
	/**
	 * Delete Staff
	 * @param name
	 */
	public void deleteStaff(String id) {
		LOG.info("deleteStaff");
		Staff staff = new Staff(id);
		dynamoMapper.delete(staff);
	}
	
}
