package it.restservice.gym.fitnesspoint.entity;

import com.amazonaws.services.dynamodbv2.datamodeling.DynamoDBAttribute;
import com.amazonaws.services.dynamodbv2.datamodeling.DynamoDBDocument;
import com.amazonaws.services.dynamodbv2.datamodeling.DynamoDBHashKey;
import com.amazonaws.services.dynamodbv2.datamodeling.DynamoDBMapperFieldModel.DynamoDBAttributeType;
import com.amazonaws.services.dynamodbv2.datamodeling.DynamoDBTable;
import com.amazonaws.services.dynamodbv2.datamodeling.DynamoDBTyped;
import com.fasterxml.jackson.annotation.JsonInclude;
import com.fasterxml.jackson.annotation.JsonInclude.Include;

import it.restservice.gym.fitnesspoint.utils.Utils;

@JsonInclude(Include.NON_NULL)
@DynamoDBDocument
@DynamoDBTable(tableName = "activity")
public class Activity {
	
	@DynamoDBHashKey(attributeName = "name")
	@DynamoDBAttribute(attributeName = "name")
	private String name;
	
	@DynamoDBAttribute(attributeName = "description")
	private String description;
	
	@DynamoDBAttribute(attributeName = "img")
	private String image;
	
	@DynamoDBAttribute(attributeName = "url")
	private String url;
	
	@DynamoDBAttribute(attributeName = "dat_ins")
	private Long dateIns;
	
	@DynamoDBAttribute(attributeName = "showed")
	@DynamoDBTyped(DynamoDBAttributeType.BOOL)
	private boolean showed;

	public Activity() { }
	
	public Activity(String name) { 
		this.name = name;
	}
	
	public Activity(String name, String description, String image, String url, Long dateIns, boolean showed) {       
		 this.name = name;    
		 this.description = description;
		 this.image = image;     
		 this.url = url;     
		 this.dateIns = dateIns;   
		 this.showed = showed;     
	}

	public String getName() {
		return name;
	}
	public void setName(String name) {
		this.name = name;
	}

	public String getDescription() {
		return description;
	}
	public void setDescription(String description) {
		this.description = description;
	}
	
	public Long getDateIns() {
		return dateIns;
	}
	public void setDateIns(Long dateIns) {
		this.dateIns = dateIns;
	}

	public String getImage() {
		return image;
	}
	public void setImage(String image) {
		this.image = image;
	}
	
	public String getUrl() {
		return url;
	}
	public void setUrl(String url) {
		this.url = url;
	}

	public boolean getShowed() {
		return showed;
	}
	public void setShowed(boolean showed) {
		this.showed = showed;
	}
	
	 @Override
     public String toString() {
		 StringBuilder sb = new StringBuilder();
		 sb.append("Activity {");
		 sb.append("name: " + name);
		 sb.append(", description:" + description);
		 sb.append(", image:" + image);
		 sb.append(", url:" + url);
		 sb.append(", dateIns:" + Utils.formatDate(dateIns, Utils.DATE_FORMAT_FULL));
		 sb.append(", showed:" + showed);
		 sb.append("}");  
         return sb.toString();
     }
	
}
