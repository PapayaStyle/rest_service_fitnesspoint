package it.restservice.gym.fitnesspoint.exception;

import java.io.Serializable;
import java.util.Date;

import org.eclipse.jetty.http.HttpStatus;

import com.fasterxml.jackson.annotation.JsonInclude;
import com.fasterxml.jackson.annotation.JsonInclude.Include;

import it.restservice.gym.fitnesspoint.utils.Utils;

@JsonInclude(Include.NON_NULL)
public class ErrorBody implements Serializable {

	private static final long serialVersionUID = -2676387464152535056L;

	private Long timestamp;
	private Integer statusCode;
	private String statusText;
	private String exception;
	private String message;
	private String path;
	private String details;

	public ErrorBody() { }
	
	public ErrorBody(Date timestamp, Integer statusCode, String statusText, 
			String exception, String message, String details, String path) {
		super();
		this.timestamp = timestamp.getTime();
		this.statusCode = statusCode;
		this.statusText = statusText;
		this.exception = exception;
		this.message = message;
		this.details = details;
		this.path = path;
	}

	public ErrorBody(GenericRestServiceException ex) {
		this.timestamp = new Date().getTime();
		this.statusCode = ex.getCode();
		this.statusText = HttpStatus.getMessage(ex.getCode());
		this.exception = getRootCause(ex).getClass().getSimpleName();
		this.message = ex.getMessage();
		this.details = ex.toString();
	}
	
	private Throwable getRootCause(Throwable ex) {
		return Utils.isNotEmpty(ex.getCause()) ? getRootCause(ex.getCause()) : ex;
	}
	
	public Date getTimestamp() {
		return new Date(timestamp);
	}
	public void setTimestamp(Long timestamp) {
		this.timestamp = timestamp;
	}
	
	public Integer getStatusCode() {
		return statusCode;
	}
	public void setStatusCode(Integer statusCode) {
		this.statusCode = statusCode;
	}

	public String getStatusText() {
		return statusText;
	}
	public void setStatusText(String statusText) {
		this.statusText = statusText;
	}

	public String getException() {
		return exception;
	}
	public void setException(String exception) {
		this.exception = exception;
	}

	public String getMessage() {
		return message;
	}
	public void setMessage(String message) {
		this.message = message;
	}

	public String getDetails() {
		return details;
	}
	public void setDetails(String details) {
		this.details = details;
	}

	public String getPath() {
		return path;
	}
	public void setPath(String path) {
		this.path = path;
	}
	
	@Override
	public String toString() {
		StringBuilder builder = new StringBuilder("ErrorBody {");
		builder.append("timestamp=" + timestamp);
		builder.append(", statusCode=" + statusCode);
		builder.append(", statusText=" + statusText);
		builder.append(", exception=" + exception);
		builder.append(", message=" + message);
		builder.append(", details=" + details);
		builder.append(", path=" + path);
		builder.append("}");
		return builder.toString();
	}
	
}
