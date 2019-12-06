package it.restservice.gym.fitnesspoint.auth;

import java.text.ParseException;
import java.util.Calendar;
import java.util.Date;

import org.apache.commons.codec.digest.DigestUtils;
import org.eclipse.jetty.http.HttpStatus;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import com.nimbusds.jose.JOSEException;
import com.nimbusds.jose.JWSAlgorithm;
import com.nimbusds.jose.JWSHeader;
import com.nimbusds.jose.JWSSigner;
import com.nimbusds.jose.JWSVerifier;
import com.nimbusds.jose.crypto.RSASSASigner;
import com.nimbusds.jose.crypto.RSASSAVerifier;
import com.nimbusds.jose.jwk.JWKSet;
import com.nimbusds.jose.jwk.RSAKey;
import com.nimbusds.jwt.JWTClaimsSet;
import com.nimbusds.jwt.SignedJWT;

import it.restservice.gym.fitnesspoint.exception.GenericRestServiceException;
import it.restservice.gym.fitnesspoint.utils.Utils;

public class JWTAuthenticator {
	
	private static final Logger LOG = LoggerFactory.getLogger(JWTAuthenticator.class);
    
    private static final String TOKEN_PREFIX = "Bearer ";
    private String authorizationToken;
    
    private String rsaKey = null;
    
    public JWTAuthenticator(String rsaKey, String token) {
    	this.rsaKey = rsaKey;
    	this.authorizationToken = token.replace(TOKEN_PREFIX, "");
    }
    
    public JWTAuthenticator(String rsaKey) {
    	this.rsaKey = rsaKey;
    }

	public boolean authenticate() {
		LOG.info("authenticate");
		try {		
			LOG.debug("authenticate --> verify the JWT integrity");
			SignedJWT signedJWT = SignedJWT.parse(authorizationToken);
			
			LOG.debug("getAuthentication --> retrieve the RSA public JWK from properties");
			JWSVerifier verifier = new RSASSAVerifier(getRsaPublicJWK());
	
			boolean valid = verifyJWT(signedJWT, verifier);
			if(!valid)
				return false;
			
			return true;
		} catch (Exception e) {
			LOG.error("authenticate -> {}: {}", e.getClass().getSimpleName(), e.getMessage(), e);
		}
        return false;
    }
	
	public String generateJWT() throws GenericRestServiceException {
		LOG.info("generateJWT");
		try {
			LOG.debug("generateJWT --> get RSA private JWK");
			RSAKey rsaJWK = getRsaPrivateJWK();
			
			LOG.debug("generateJWT --> serialize JWK");
			String serializeJWT = serializeJWT(rsaJWK);
			return serializeJWT;
		} catch (Exception e) {
			LOG.error("generateJWT -> {}: {}", e.getClass().getSimpleName(), e.getMessage(), e);
			throw new GenericRestServiceException(
					HttpStatus.UNAUTHORIZED_401,
					"generateJWT -> "+ e.getClass().getSimpleName() + ": " + e.getMessage(), 
					e);
		}
	}

	/**
	 * get RSA private JWK
	 * @return RSAKey
	 * @throws JOSEException
	 * @throws ParseException 
	 */
	private RSAKey getRsaPrivateJWK() throws ParseException {
		JWKSet privateKey = JWKSet.parse(rsaKey);
		RSAKey rsaJWK = (RSAKey) privateKey.getKeys().get(0);
		return rsaJWK;
	}
	
	/**
	 * get RSA public JWK
	 * @return RSAKey
	 * @throws JOSEException
	 * @throws ParseException 
	 */
	private RSAKey getRsaPublicJWK() throws ParseException {
		JWKSet privateKey = JWKSet.parse(rsaKey);
		RSAKey rsaJWK = (RSAKey) privateKey.getKeys().get(0);
		return rsaJWK.toPublicJWK();
	}
	
	/**
	 * verify token data
	 * @param signedJWT
	 * @param verifier
	 * @return boolean
	 * @throws JOSEException
	 * @throws ParseException
	 */
	private boolean verifyJWT(SignedJWT signedJWT, JWSVerifier verifier) throws JOSEException, ParseException {
		LOG.debug("verifyJWT --> verify the RSA signature");
		
		if(!signedJWT.verify(verifier)) {
			LOG.error("verifyJWT -> Invalid Signature: " + authorizationToken);
			return false;
		}
		
		LOG.debug("verifyJWT --> verify Issue Time and Expire Time");
		Date sysdate = new Date();
		
		Date issueTime = addSeconds(signedJWT.getJWTClaimsSet().getIssueTime(), -2);
		if(!sysdate.after(issueTime)) {
			LOG.error("verifyJWT -> Invalid Issue Time: {}", 
				Utils.isNotEmpty(issueTime) ? Utils.formatDate(issueTime, Utils.DATE_FORMAT_FULL) : null );
			return false;
		}
		
		Date expirationTime = addSeconds(signedJWT.getJWTClaimsSet().getExpirationTime(), 2);
		if(!sysdate.before(expirationTime)) {
			LOG.error("verifyJWT -> Token Expired: {}", 
					Utils.isNotEmpty(expirationTime) ? Utils.formatDate(expirationTime, Utils.DATE_FORMAT_FULL) : null);
			return false;
		}

		LOG.debug("verifyJWT --> verify that the subject is not empty");
		if(Utils.isEmpty(signedJWT.getJWTClaimsSet().getSubject())) {
			LOG.error("verifyJWT -> Empty Subject");
			return false;
		}
		
		return true;
	}
	
	private Date addSeconds(Date date, int seconds) {
		Calendar cal = Calendar.getInstance();
		cal.setTime(date);
		cal.add(Calendar.SECOND, seconds);
		return cal.getTime();
	}
	
	/**
	 * generate and serialize new JWT
	 * @param rsaKey
	 * @return String
	 * @throws JOSEException
	 */
	private String serializeJWT(RSAKey rsaKey) throws JOSEException {
		LOG.debug("serializeJWT --> create expiration time");
		Calendar cal = Calendar.getInstance();
		cal.add(Calendar.HOUR, 1); // 1 hour expiretion time
		Date expirationTime = cal.getTime();
		
		LOG.debug("serializeJWT --> create issue time");
		long issueTime = new Date().getTime() - 60 * 1000;
		
		LOG.debug("serializeJWT --> create RSA-signer with the private key");
		JWSSigner signer = new RSASSASigner(rsaKey);
		
		LOG.debug("serializeJWT --> create subject");
		String subject = "new-fitnesspoint";
		
		LOG.debug("serializeJWT --> prepare JWT with claims set");
		JWTClaimsSet claimsSet = new JWTClaimsSet.Builder()
		    .subject(subject)
		    .issuer(null)
		    .expirationTime(expirationTime)
		    .issueTime(new Date(issueTime))
		    .audience("API")
		    .jwtID(DigestUtils.md5Hex(subject))
		    .build();
		
		LOG.debug("serializeJWT --> create signed JWT");
		SignedJWT signedJWT = new SignedJWT(
			    new JWSHeader
			    	.Builder(JWSAlgorithm.RS256)
			    	.keyID(rsaKey.getKeyID())
			    	.build(),
			    claimsSet);
		
		LOG.debug("serializeJWT --> compute the RSA signature");
		signedJWT.sign(signer);
		
		LOG.debug("serializeJWT --> serialize signed JWT");
		String serializeJWT = signedJWT.serialize();
		return serializeJWT;
	}
	
}
