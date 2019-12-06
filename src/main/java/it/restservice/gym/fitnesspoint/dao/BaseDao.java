package it.restservice.gym.fitnesspoint.dao;

import java.util.List;

import com.amazonaws.services.dynamodbv2.AmazonDynamoDB;
import com.amazonaws.services.dynamodbv2.datamodeling.DynamoDBQueryExpression;
import com.amazonaws.services.dynamodbv2.model.AttributeValue;
import com.amazonaws.services.dynamodbv2.model.ComparisonOperator;
import com.amazonaws.services.dynamodbv2.model.Condition;
import com.amazonaws.services.dynamodbv2.model.ListTablesResult;

import it.restservice.gym.fitnesspoint.entity.User;
import it.restservice.gym.fitnesspoint.utils.Utils;

public class BaseDao extends AbstractDao {
	
	public BaseDao(AmazonDynamoDB dynamoClient) {
		initDynamoDB(dynamoClient);
	}

	/**
	 * return list of all table stored in DynamoDB
	 * @return ListTablesResult
	 */
	public List<String> getAllTables() {
		LOG.info("getAllTables");
		ListTablesResult res = dynamoClient.listTables();
		return Utils.isNotEmpty(res) ? res.getTableNames() : null;
	}
	
	/**
	 * Get Activity By Name
	 * @param name
	 * @return Activity
	 */
	public User login(String username, String password) {
		LOG.info("login");
		User hashKey = new User(username);
		
		Condition rangeKeyCondition = new Condition()
		        .withComparisonOperator(ComparisonOperator.EQ)
		        .withAttributeValueList(new AttributeValue().withS(password));
		
		DynamoDBQueryExpression<User> queryExpression = new DynamoDBQueryExpression<User>()
				.withHashKeyValues(hashKey)
				.withRangeKeyCondition("password", rangeKeyCondition);
		
		List<User> result = dynamoMapper.query(User.class, queryExpression);
//		Map<String, String> expressionAttributeNames = new HashMap<String, String>();
//		expressionAttributeNames.put("#username", "username");
//		expressionAttributeNames.put("#password", "password");
//		
//		Map<String, AttributeValue> expressionAttributeValues = new HashMap<String, AttributeValue>();
//		expressionAttributeValues.put(":username", new AttributeValue().withS(username));
//		expressionAttributeValues.put(":password", new AttributeValue().withS(password));
//		
//		DynamoDBScanExpression scanExpression = new DynamoDBScanExpression()
//				.withFilterExpression("#username = :username and #password = :password")
//				.withExpressionAttributeNames(expressionAttributeNames)
//				.withExpressionAttributeValues(expressionAttributeValues);
//		
//		List<User> result = dynamoMapper.scan(User.class, scanExpression);
		return Utils.isNotEmpty(result) ? result.get(0) : null;
	}
	
}
