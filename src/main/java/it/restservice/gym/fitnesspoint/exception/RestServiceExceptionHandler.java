package it.restservice.gym.fitnesspoint.exception;

import javax.ws.rs.core.MediaType;
import javax.ws.rs.core.Response;
import javax.ws.rs.ext.ExceptionMapper;
import javax.ws.rs.ext.Provider;

@Provider
public class RestServiceExceptionHandler implements ExceptionMapper<GenericRestServiceException> {

	@Override
	public Response toResponse(GenericRestServiceException exception) {
		ErrorBody body = new ErrorBody(exception);
		
        return Response.status(exception.getCode())
                .entity(body)
                .type(MediaType.APPLICATION_JSON)
                .build();
    }

}
