package it.restservice.gym.fitnesspoint.auth;

import java.util.Date;

import javax.ws.rs.container.ContainerRequestContext;
import javax.ws.rs.container.ContainerRequestFilter;
import javax.ws.rs.core.MediaType;
import javax.ws.rs.core.Response;

import org.eclipse.jetty.http.HttpStatus;
import org.eclipse.jetty.http.HttpStatus.Code;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import it.restservice.gym.fitnesspoint.exception.ErrorBody;
import it.restservice.gym.fitnesspoint.utils.Utils;

@Authenticator
public class AuthenticatorFilter implements ContainerRequestFilter {

	private final Logger LOG = LoggerFactory.getLogger(AuthenticatorFilter.class);
	
    private static final String HEADER_TOKEN = "Authorization";
    private String rsaKey = null;
    
    public AuthenticatorFilter(String rsaKey) {
    	this.rsaKey = rsaKey;
    }
 
    @Override
    public void filter(ContainerRequestContext context) {
    	LOG.info("AuthenticatorFilter --> filter");
    	
        final String token = extractToken(context);
        
        if (Utils.isEmpty(token))
        	context.abortWith(responseError(HttpStatus.PRECONDITION_FAILED_412));
        else {
        	JWTAuthenticator jwtAuth = new JWTAuthenticator(rsaKey, token);
 
	        if (!jwtAuth.authenticate())
	            context.abortWith(responseError(HttpStatus.UNAUTHORIZED_401));
        }
    }
    
    private String extractToken(ContainerRequestContext context) {
        String token = context.getHeaderString(HEADER_TOKEN);
        if(Utils.isEmpty(token))
        	context.abortWith(responseError(HttpStatus.PRECONDITION_FAILED_412));
        
        return token;
    }
    
    private Response responseError(int statusCode) {
    	String message = null;
    	if(statusCode == HttpStatus.PRECONDITION_FAILED_412)
    		message = "Missing Authentication headers";
    	
    	if(statusCode == HttpStatus.UNAUTHORIZED_401)
    		message = "Invalid Authentication";
    	
    	Code httpStatus = HttpStatus.getCode(statusCode);
    	
    	ErrorBody body = new ErrorBody(new Date(), 
    			httpStatus.getCode(),
    			httpStatus.getMessage(), 
        		"AuthenticationException", 
        		message, 
        		null, 
        		null);
    	
    	return Response.status(httpStatus.getCode())
                .type(MediaType.APPLICATION_JSON)
                .entity(body)
                .build();
    }
	
}
