package it.restservice.gym.fitnesspoint.utils;

import java.text.SimpleDateFormat;
import java.util.Collection;
import java.util.Date;
import java.util.Map;

/**
 * 
 * Classe contenitore di metodi statici di utilità generica
 * 
 */
public class Utils {
	
	public static final String DATE_FORMAT_FULL = "dd/MM/yyyy HH:mm:ss:SSS";
	public static final String DATE_FORMAT_SHORT = "dd/MM/yyyy";

	public static final String formatDate(Date date, String format) {
		if(isNotEmpty(date) && isNotEmpty(format))
			return new SimpleDateFormat(format).format(date);
		return null;
	}
	
	public static final String formatDate(Long millisencond, String format) {
		if(isNotEmpty(millisencond) && isNotEmpty(format))
			return new SimpleDateFormat(format).format(new Date(millisencond));
		return null;
	}
	
	/**
     * Check if a string is empty or null.
     * 
     * @param value
     *            - string to check
     */
    public static final boolean isEmpty(String value) {
        return value == null || value.trim().length() == 0;
    }

    /**
     * Check if a string is not empty.
     * 
     * @param value
     *            - string to check
     */
    public static final boolean isNotEmpty(String value) {
        return !isEmpty(value);
    }

    /**
     * Check if a Collection is not empty and not 'null'.
     * 
     * @param value
     *            - collection to check
     */
    public static final boolean isEmpty(Collection<?> value) {
        return (value == null || value.isEmpty());
    }
    
    /**
     * Check if a Collection is empty or 'null'.
     * 
     * @param value
     *            - collection to check
     */
    public static final boolean isNotEmpty(Collection<?> value) {
    	return !isEmpty(value);
    }

    /**
     * Check if a Map is not empty and not 'null'.
     * 
     * @param value
     *            - collection to check
     */
    public static final boolean isEmpty(Map<?, ?> value) {
        return (value == null || value.isEmpty());
    }
    
    /**
     * Check if a Map is empty or 'null'.
     * 
     * @param value
     *            - collection to check
     */
    public static final boolean isNotEmpty(Map<?, ?> value) {
        return !isEmpty(value);
    }

    /**
     * Check if an object is null. If it is a string call the relative isEmpty.
     * 
     * @param value
     */
    public static final boolean isEmpty(Object value) {
        if (value instanceof String)
            return isEmpty(value.toString());
        else if (value == null)
        	return true;
        return false;
    }
    
    /**
     * 
     * @param value
     * @return
     */
    public static boolean isNotEmpty(Object value) {
    	return !isEmpty(value);
    }

    /**
     * Check if an Array is not empty and not 'null'.
     * 
     * @param value
     *            - collection to check
     */
    public static final boolean isEmpty(Object[] objects) {
        return (objects == null || objects.length == 0);
    }
    
}
