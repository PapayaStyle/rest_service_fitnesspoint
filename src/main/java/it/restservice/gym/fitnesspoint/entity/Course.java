package it.restservice.gym.fitnesspoint.entity;

import com.amazonaws.services.dynamodbv2.datamodeling.DynamoDBAttribute;
import com.amazonaws.services.dynamodbv2.datamodeling.DynamoDBDocument;
import com.amazonaws.services.dynamodbv2.datamodeling.DynamoDBTypeConvertedJson;
import com.fasterxml.jackson.annotation.JsonInclude;
import com.fasterxml.jackson.annotation.JsonInclude.Include;

@JsonInclude(Include.NON_NULL)
@DynamoDBDocument
public class Course {
	
	@DynamoDBAttribute(attributeName = "activity")
	@DynamoDBTypeConvertedJson
	private Activity activity;
	
	@DynamoDBAttribute(attributeName = "note")
	private String note;
	
	public Activity getActivity() {
		return activity;
	}
	public void setActivity(Activity activity) {
		this.activity = activity;
	}
	
	public String getNote() {
		return note;
	}
	public void setNote(String note) {
		this.note = note;
	}
	
	@Override
    public String toString() {
		 StringBuilder sb = new StringBuilder();
		 sb.append("Course {");
		 sb.append("activity: " + activity.toString());
		 sb.append(", note:" + note);
		 sb.append("}");  
        return sb.toString();
    }
	
}
