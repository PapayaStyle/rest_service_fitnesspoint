package it.restservice.gym.fitnesspoint.config;

import javax.validation.Valid;
import javax.validation.constraints.NotNull;

import org.hibernate.validator.constraints.NotEmpty;

import com.fasterxml.jackson.annotation.JsonProperty;

import io.dropwizard.Configuration;
import io.dropwizard.bundles.assets.AssetsBundleConfiguration;
import io.dropwizard.bundles.assets.AssetsConfiguration;

public class ApiConfiguration extends Configuration implements AssetsBundleConfiguration {

	@NotEmpty
	@JsonProperty
	private String dateFormat;
	
	@Valid
    @NotNull
    @JsonProperty
    private AssetsConfiguration assets;

	@Valid
    @NotNull
    @JsonProperty("endpoint_dynamodb")
    private String endpointDynamoDB;
	
	@Valid
    @NotNull
    @JsonProperty("aws_region")
    private String awsRegion;
	
	@Valid
    @NotNull
    @JsonProperty("aws_access_key_id")
	private String awsAccessKeyId;
	
	@Valid
    @NotNull
    @JsonProperty("aws_secret_access_key")
	private String awsSecretAccessKey;
	
	@Valid
    @NotNull
    @JsonProperty("jwt_rsa_key")
	private String jwtRsaKey;

	public String getDateFormat() {
		return dateFormat;
	}

	@Override
	public AssetsConfiguration getAssetsConfiguration() {
		 return assets;
	}

	public String getEndpointDynamoDB() {
		return endpointDynamoDB;
	}
	
	public String getAwsRegion() {
		return awsRegion;
	}

	public String getAwsAccessKeyId() {
		return awsAccessKeyId;
	}

	public String getAwsSecretAccessKey() {
		return awsSecretAccessKey;
	}

	public String getJwtRsaKey() {
		return jwtRsaKey;
	}

}
