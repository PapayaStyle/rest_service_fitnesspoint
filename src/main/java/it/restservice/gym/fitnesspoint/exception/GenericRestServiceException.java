package it.restservice.gym.fitnesspoint.exception;

import org.eclipse.jetty.http.HttpStatus;

public class GenericRestServiceException extends Throwable {

	private static final long serialVersionUID = -1486175737094011420L;

	private int code;
	
    public GenericRestServiceException() {
        this(HttpStatus.INTERNAL_SERVER_ERROR_500);
    }
    
    public GenericRestServiceException(int code) {
        this(code, HttpStatus.getMessage(code), null);
    }
    
    public GenericRestServiceException(int code, String message) {
        this(code, message, null);
    }
    
    public GenericRestServiceException(String message, Throwable throwable) {
    	this(HttpStatus.INTERNAL_SERVER_ERROR_500, message, throwable);
    }
    
    public GenericRestServiceException(int code, String message, Throwable throwable) {
        super(message, throwable);
        this.code = code;
    }
    
    public int getCode() {
        return code;
    }
    
}
