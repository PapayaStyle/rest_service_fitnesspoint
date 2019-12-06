package it.restservice.gym.fitnesspoint.entity;

import java.util.List;

import com.amazonaws.services.dynamodbv2.datamodeling.DynamoDBAttribute;
import com.amazonaws.services.dynamodbv2.datamodeling.DynamoDBAutoGeneratedKey;
import com.amazonaws.services.dynamodbv2.datamodeling.DynamoDBHashKey;
import com.amazonaws.services.dynamodbv2.datamodeling.DynamoDBMapperFieldModel.DynamoDBAttributeType;
import com.amazonaws.services.dynamodbv2.datamodeling.DynamoDBTable;
import com.amazonaws.services.dynamodbv2.datamodeling.DynamoDBTypeConvertedJson;
import com.amazonaws.services.dynamodbv2.datamodeling.DynamoDBTyped;
import com.fasterxml.jackson.annotation.JsonInclude;
import com.fasterxml.jackson.annotation.JsonInclude.Include;

import it.restservice.gym.fitnesspoint.utils.Utils;

@JsonInclude(Include.NON_NULL)
@DynamoDBTable(tableName = "staff")
public class Staff {

	@DynamoDBHashKey(attributeName = "id")
	@DynamoDBAutoGeneratedKey
	private String id;
	
	@DynamoDBAttribute(attributeName = "name")
	private String name;
	
	@DynamoDBAttribute(attributeName = "activity")
	private String activity;
	
	@DynamoDBAttribute(attributeName = "description")
	private String description;
	
	@DynamoDBAttribute(attributeName = "portrait")
	private String portrait;
	
	@DynamoDBAttribute(attributeName = "img")
	private String image;
	
	@DynamoDBAttribute(attributeName = "showed")
	@DynamoDBTyped(DynamoDBAttributeType.BOOL)
	private boolean showed;
	
	@DynamoDBAttribute(attributeName = "dateIns")
	private Long dateIns;
	
	@DynamoDBAttribute(attributeName = "activities")
	@DynamoDBTypeConvertedJson
	private List<Activity> activities;

	public Staff() {}
	
	public Staff(String id) {
		this.id = id;
	}
	
	public Staff(String id, String name) {
		this.id = id;
		this.name = name;
	}
	
	public String getId() {
		return id;
	}
	public void setId(String id) {
		this.id = id;
	}

	public String getName() {
		return name;
	}
	public void setName(String name) {
		this.name = name;
	}
	
	public String getActivity() {
		return activity;
	}
	public void setActivity(String activity) {
		this.activity = activity;
	}

	public String getDescription() {
		return description;
	}
	public void setDescription(String description) {
		this.description = description;
	}

	public String getPortrait() {
		return portrait;
	}
	public void stPortrait(String portrait) {
		this.portrait = portrait;
	}
	
	public String getImage() {
		return image;
	}
	public void setImage(String image) {
		this.image = image;
	}

	public boolean getShowed() {
		return showed;
	}
	public void setShowed(boolean showed) {
		this.showed = showed;
	}
	
	public Long getDateIns() {
		return dateIns;
	}
	public void setDateIns(Long dateIns) {
		this.dateIns = dateIns;
	}

	public List<Activity> getActivities() {
		return activities;
	}
	public void setActivities(List<Activity> activities) {
		this.activities = activities;
	}
	
	@Override
	public String toString() {
		StringBuilder sb = new StringBuilder();
		sb.append("Staff {");
		sb.append("id: " + id);
		sb.append(", name: " + name);
		sb.append(", activity:" + activity);
		sb.append(", description:" + description);
		sb.append(", portrait:" + portrait);
		sb.append(", image:" + image);
		sb.append(", showed:" + showed);
		sb.append(", dateIns:" + Utils.formatDate(dateIns, Utils.DATE_FORMAT_FULL));
		sb.append(", activities: [" + (Utils.isNotEmpty(activities) ? activities.toString() : null));
		sb.append("]}");  
		return sb.toString();
	}
}
