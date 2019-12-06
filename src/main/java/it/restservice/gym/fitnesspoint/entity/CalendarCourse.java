package it.restservice.gym.fitnesspoint.entity;

import java.util.List;

import com.amazonaws.services.dynamodbv2.datamodeling.DynamoDBAttribute;
import com.amazonaws.services.dynamodbv2.datamodeling.DynamoDBHashKey;
import com.amazonaws.services.dynamodbv2.datamodeling.DynamoDBTable;
import com.fasterxml.jackson.annotation.JsonInclude;
import com.fasterxml.jackson.annotation.JsonInclude.Include;

@JsonInclude(Include.NON_NULL)
@DynamoDBTable(tableName = "calendar")
public class CalendarCourse {

	@DynamoDBHashKey(attributeName = "time")
	private String time;
	
	@DynamoDBAttribute(attributeName = "monday")
	private List<Course> monday;
	
	@DynamoDBAttribute(attributeName = "tuesday")
	private List<Course> tuesday;
	
	@DynamoDBAttribute(attributeName = "wednesday")
	private List<Course> wednesday;
	
	@DynamoDBAttribute(attributeName = "thursday")
	private List<Course> thursday;
	
	@DynamoDBAttribute(attributeName = "friday")
	private List<Course> friday;

	public CalendarCourse() {}
	
	public CalendarCourse(String time) {
		this.time = time;
	}
	
	public String getTime() {
		return time;
	}
	public void setTime(String time) {
		this.time = time;
	}

	public List<Course> getMonday() {
		return monday;
	}
	public void setMonday(List<Course> monday) {
		this.monday = monday;
	}

	public List<Course> getTuesday() {
		return tuesday;
	}
	public void setTuesday(List<Course> tuesday) {
		this.tuesday = tuesday;
	}

	public List<Course> getWednesday() {
		return wednesday;
	}
	public void setWednesday(List<Course> wednesday) {
		this.wednesday = wednesday;
	}

	public List<Course> getThursday() {
		return thursday;
	}
	public void setThursday(List<Course> thursday) {
		this.thursday = thursday;
	}

	public List<Course> getFriday() {
		return friday;
	}
	public void setFriday(List<Course> friday) {
		this.friday = friday;
	}
	
	@Override
    public String toString() {
		 StringBuilder sb = new StringBuilder();
		 sb.append("CalendarCourse {");
		 sb.append("monday: [" + monday.toString());
		 sb.append("], tuesday:" + tuesday.toString());
		 sb.append("], wednesday:" + wednesday.toString());
		 sb.append("], thursday:" + thursday.toString());
		 sb.append("], friday:" + friday.toString());
		 sb.append("]}");  
        return sb.toString();
    }
	
}
