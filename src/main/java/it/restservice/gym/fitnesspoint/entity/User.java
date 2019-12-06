package it.restservice.gym.fitnesspoint.entity;

import com.amazonaws.services.dynamodbv2.datamodeling.DynamoDBAttribute;
import com.amazonaws.services.dynamodbv2.datamodeling.DynamoDBHashKey;
import com.amazonaws.services.dynamodbv2.datamodeling.DynamoDBRangeKey;
import com.amazonaws.services.dynamodbv2.datamodeling.DynamoDBTable;
import com.fasterxml.jackson.annotation.JsonIgnore;
import com.fasterxml.jackson.annotation.JsonInclude;
import com.fasterxml.jackson.annotation.JsonInclude.Include;

import it.restservice.gym.fitnesspoint.utils.Utils;

@JsonInclude(Include.NON_NULL)
@DynamoDBTable(tableName = "user")
public class User {

	@DynamoDBHashKey(attributeName = "username")
	private String username;
	
	@JsonIgnore
	@DynamoDBRangeKey(attributeName = "password")
	private String password;
	
	@DynamoDBAttribute(attributeName = "name")
	private String name;
	
	@DynamoDBAttribute(attributeName = "surname")
	private String surname;
	
	@DynamoDBAttribute(attributeName = "dat_ins")
	private Long dateIns;
	
	private String token;
	
	public User() {}

	public User(String username) {
		this.username = username;
	}
	
	public User(String username, String password) {
		this(username);
		this.password = password;
	}

	public String getUsername() {
		return username;
	}
	public void setUsername(String username) {
		this.username = username;
	}

	public String getPassword() {
		return password;
	}
	public void setPassword(String password) {
		this.password = password;
	}

	public String getName() {
		return name;
	}
	public void setName(String name) {
		this.name = name;
	}

	public String getSurname() {
		return surname;
	}
	public void setSurname(String surname) {
		this.surname = surname;
	}

	public Long getDateIns() {
		return dateIns;
	}
	public void setDateIns(Long dateIns) {
		this.dateIns = dateIns;
	}

	public String getToken() {
		return token;
	}
	public void setToken(String token) {
		this.token = token;
	}
	
	@Override
	public String toString() {
		StringBuilder sb = new StringBuilder();
		sb.append("User {");
		sb.append("username: " + username);
		sb.append(", name: " + name);
		sb.append(", surname:" + surname);
		sb.append(", dateIns:" + Utils.formatDate(dateIns, Utils.DATE_FORMAT_FULL));
		sb.append(", token: " + token);
		sb.append("}");  
		return sb.toString();
	}
}
