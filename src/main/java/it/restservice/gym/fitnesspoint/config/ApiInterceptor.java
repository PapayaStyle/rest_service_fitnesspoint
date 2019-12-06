package it.restservice.gym.fitnesspoint.config;

import java.io.ByteArrayInputStream;
import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.io.InputStream;

import javax.ws.rs.container.ContainerRequestContext;
import javax.ws.rs.container.ContainerRequestFilter;
import javax.ws.rs.container.ContainerResponseContext;
import javax.ws.rs.container.ContainerResponseFilter;

import org.glassfish.jersey.message.internal.ReaderWriter;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

public class ApiInterceptor implements ContainerRequestFilter, ContainerResponseFilter {

	private final Logger LOG = LoggerFactory.getLogger(ApiInterceptor.class);
	
	@Override
	public void filter(ContainerRequestContext requestContext) 
			throws IOException {
    	LOG.info("Request Filter");
    	StringBuilder sb = new StringBuilder();
    	sb.append("Method: ").append(requestContext.getMethod());
        sb.append(" - Path: ").append(requestContext.getUriInfo().getAbsolutePath());
        sb.append(" - Header: ").append(requestContext.getHeaders());
        sb.append(" - Entity: ").append(getEntityBody(requestContext));
        LOG.info("HTTP REQUEST: {}", sb.toString());
	}
	
	private String getEntityBody(ContainerRequestContext requestContext) {
        ByteArrayOutputStream out = new ByteArrayOutputStream();
        InputStream in = requestContext.getEntityStream();
         
        final StringBuilder b = new StringBuilder();
        try {
            ReaderWriter.writeTo(in, out);
 
            byte[] requestEntity = out.toByteArray();
            if (requestEntity.length == 0)
                b.append("").append("\n");
            else
                b.append(new String(requestEntity)).append("\n");
            
            requestContext.setEntityStream( new ByteArrayInputStream(requestEntity) );
 
        } catch (IOException e) {
        	LOG.error("getEntityBody -> {}: {}", e.getClass().getSimpleName(), e.getMessage(), e);
        }
        return b.toString();
    }

	@Override
	public void filter(ContainerRequestContext requestContext, ContainerResponseContext responseContext)
			throws IOException {
		LOG.info("Response Filter");
		
		StringBuilder sb = new StringBuilder();
        sb.append("Header: ").append(responseContext.getHeaders());
        sb.append(" - Entity: ").append(responseContext.getEntity());
        LOG.info("HTTP RESPONSE: {}", sb.toString());
	}
	
//  @Override
//	public void doFilter(ServletRequest request, ServletResponse response, FilterChain chain)
//			throws IOException, ServletException {
//    	LOG.info("doFilter");
//    	
//    	res = (HttpServletResponse) response;
//    	addResponseHeader();
//		
//    	chain.doFilter(request, res);
//	}    

//	@Override
//	public void init(FilterConfig filterConfig) throws ServletException {}

//	@Override
//	public void destroy() {}

//	private void addResponseHeader() {
//		res.addHeader("Access-Control-Allow-Origin", "*");
//	    res.addHeader("Accept", "application/json, text/plain, multipart/form-data, */*");
//	    res.addHeader("Content-Type", "application/json; charset=UTF-8");
//	    res.addHeader("Access-Control-Allow-Methods", "HEAD, OPTIONS, GET, POST ,PUT, DELETE");
//	    res.addHeader("Access-Control-Allow-Headers", 
//	    		"Authorization, " 						+ 
//	    		"Access-Control-Allow-Headers, " 		+ 
//	    		"Origin, "								+ 
//	    		"Accept, " 								+ 
//	    		"X-Requested-With, " 					+ 
//	    		"Content-Type, " 						+ 
//	    		"Access-Control-Requ+ est-Method, " 	+ 
//	    		"Access-Control-Requ+ est-Headers");
//	}
	
}
