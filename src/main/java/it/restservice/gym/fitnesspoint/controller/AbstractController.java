package it.restservice.gym.fitnesspoint.controller;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

public class AbstractController {
	
	protected final Logger LOG = LoggerFactory.getLogger(getClass());

	protected String parseMessage(String method, Exception ex) {
		StringBuilder sb = new StringBuilder();
		sb.append(method);
		sb.append("-> ");
		sb.append(ex.getClass().getSimpleName());
		sb.append(": ");
		sb.append(ex.getMessage());
		return sb.toString();
	}
	
}
