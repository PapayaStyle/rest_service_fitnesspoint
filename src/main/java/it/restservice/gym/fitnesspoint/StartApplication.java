package it.restservice.gym.fitnesspoint;

import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.EnumSet;
import java.util.stream.Collectors;
import java.util.stream.Stream;

import javax.servlet.DispatcherType;
import javax.servlet.FilterRegistration;

import org.eclipse.jetty.servlets.CrossOriginFilter;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import com.amazonaws.client.builder.AwsClientBuilder;
import com.amazonaws.services.dynamodbv2.AmazonDynamoDB;
import com.amazonaws.services.dynamodbv2.AmazonDynamoDBClientBuilder;
import com.fasterxml.jackson.annotation.JsonInclude;

import io.dropwizard.Application;
import io.dropwizard.assets.AssetsBundle;
import io.dropwizard.setup.Bootstrap;
import io.dropwizard.setup.Environment;
import io.swagger.v3.jaxrs2.integration.resources.OpenApiResource;
import io.swagger.v3.oas.integration.SwaggerConfiguration;
import io.swagger.v3.oas.models.OpenAPI;
import io.swagger.v3.oas.models.info.Contact;
import io.swagger.v3.oas.models.info.Info;
import io.swagger.v3.oas.models.info.License;
import it.restservice.gym.fitnesspoint.auth.AuthenticatorFilter;
import it.restservice.gym.fitnesspoint.config.ApiConfiguration;
import it.restservice.gym.fitnesspoint.config.ApiInterceptor;
import it.restservice.gym.fitnesspoint.config.TemplateHealthCheck;
import it.restservice.gym.fitnesspoint.controller.ActivityController;
import it.restservice.gym.fitnesspoint.controller.BaseController;
import it.restservice.gym.fitnesspoint.controller.CalendarCourseController;
import it.restservice.gym.fitnesspoint.controller.NewsController;
import it.restservice.gym.fitnesspoint.controller.StaffController;
import it.restservice.gym.fitnesspoint.exception.RestServiceExceptionHandler;

public class StartApplication extends Application<ApiConfiguration> {

	private static final Logger LOG = LoggerFactory.getLogger(StartApplication.class);
	
	private String rsaJWT;

	public static void main(final String[] args) throws Exception {
		new StartApplication().run(args);
	}

	@Override
	public void initialize(Bootstrap<ApiConfiguration> bootstrap) {
		LOG.info("register swagger-ui page");
		bootstrap.addBundle(new AssetsBundle( "/assets", "/openapi", "swagger-ui.html", "swagger-ui" ));
		
		LOG.info("register web application");
		bootstrap.addBundle(new AssetsBundle( "/webapp", "/", "index.html", "angular"));
	}
	
	@Override
	public void run(ApiConfiguration configuration, Environment environment) {
		SwaggerConfiguration swagger = initSwagger(configuration, environment);
		AmazonDynamoDB dynamoDB = initDynamoDB(configuration);
		
		final TemplateHealthCheck healthCheck = new TemplateHealthCheck();
		environment.healthChecks().register("template", healthCheck);
		
		DateFormat eventDateFormat = new SimpleDateFormat(configuration.getDateFormat());
		environment.getObjectMapper().setDateFormat(eventDateFormat);	
		
		rsaJWT = configuration.getJwtRsaKey();
		
		// register interceptor
		environment.jersey().register(new ApiInterceptor());
		
		// register authenticator
		environment.jersey().register(new AuthenticatorFilter(rsaJWT));
		
		// register exception handler
		environment.jersey().register(new RestServiceExceptionHandler());
		
		controllerRegister(environment, dynamoDB);
		
		environment.getObjectMapper().setSerializationInclusion(JsonInclude.Include.NON_NULL);
		environment.jersey().register(new OpenApiResource().openApiConfiguration(swagger));
		
		// enable cors policy
		enableCORS(environment);
	    
		LOG.info("RUN");
	}
	
	/**
	 * Register application controller to Jersey environment
	 * @param environment
	 * @param dynamoDB
	 */
	private void controllerRegister(Environment environment, AmazonDynamoDB dynamoDB) {
		LOG.info("Register enviroment");
		environment.jersey().register(new BaseController(dynamoDB, rsaJWT));
		environment.jersey().register(new ActivityController(dynamoDB));
		environment.jersey().register(new CalendarCourseController(dynamoDB));
		environment.jersey().register(new StaffController(dynamoDB));
		environment.jersey().register(new NewsController(dynamoDB));
	}

	/**
	 * Initialize Swagger2 resources
	 * @param configuration
	 * @param environment
	 * @return SwaggerConfiguration
	 */
	private SwaggerConfiguration initSwagger(ApiConfiguration configuration, Environment environment) {
		LOG.info("init Swagger resources");
		OpenAPI api = new OpenAPI();
		
		Contact contact = new Contact();
		contact.setName("Danny Cuttaia");
		contact.setEmail("danny.cuttaia@gmail.com");
		
		License license = new License();
		license.setName("Apache 2.0");
		license.setUrl("https://www.apache.org/licenses/LICENSE-2.0");
		
		Info info = new Info();
		info.setTitle("Fitness Point Rest Service API");
		info.setDescription("API Rest Service Fitness Point Gym");
		info.setVersion("1.0");
		info.setContact(contact);
		info.setLicense(license);
		
//		List<Server> servers = new ArrayList<>();
//	    servers.add(new Server().url("/api"));
	    
		api.info(info);
//		api.servers(servers);
		
		SwaggerConfiguration swaggerConfig = new SwaggerConfiguration()
	            .openAPI(api)
	            .prettyPrint(true)
	            .resourcePackages(Stream.of("it.restservice.gym.fitnesspoint.controller").collect(Collectors.toSet()));
		
		return swaggerConfig;
	}

	/**
	 * Initialize DynamoDB connection
	 * @param configuration
	 * @return AmazonDynamoDB
	 */
	private AmazonDynamoDB initDynamoDB(ApiConfiguration configuration) {
		LOG.info("init DynamoDB resources");	
		AmazonDynamoDB client = AmazonDynamoDBClientBuilder.standard()
				.withEndpointConfiguration(
						new AwsClientBuilder.EndpointConfiguration(
								configuration.getEndpointDynamoDB(), 
								configuration.getAwsRegion()
						)
				)
				.build(); 
		return client;
	}
	
	private void enableCORS(Environment environment) {
		final FilterRegistration.Dynamic cors = environment.servlets().addFilter("CORS", CrossOriginFilter.class);

	    // Configure CORS parameters
	    cors.setInitParameter("allowedOrigins", "*");
	    cors.setInitParameter("allowedHeaders", "X-Requested-With,Content-Type,Accept,Origin");
	    cors.setInitParameter("allowedMethods", "OPTIONS,GET,PUT,POST,DELETE,HEAD");

	    // Add URL mapping
	    cors.addMappingForUrlPatterns(EnumSet.allOf(DispatcherType.class), true, "/*");
	}
	
}