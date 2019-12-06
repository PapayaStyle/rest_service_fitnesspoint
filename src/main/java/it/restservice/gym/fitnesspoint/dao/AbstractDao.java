package it.restservice.gym.fitnesspoint.dao;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import com.amazonaws.services.dynamodbv2.AmazonDynamoDB;
import com.amazonaws.services.dynamodbv2.datamodeling.DynamoDBMapper;

public abstract class AbstractDao {

	protected final Logger LOG = LoggerFactory.getLogger(getClass());
	
	protected DynamoDBMapper dynamoMapper;
	protected AmazonDynamoDB dynamoClient;
	
	protected void initDynamoDB(AmazonDynamoDB dynamoClient) {
		this.dynamoClient = dynamoClient;
		this.dynamoMapper = new DynamoDBMapper(dynamoClient);
	}
	
}
