package ar.edu.unrc.exa.dc.dose2016.riocuartobandasderock.main;



import ar.edu.unrc.exa.dc.dose2016.riocuartobandasderock.dao.SongDAO;
import ar.edu.unrc.exa.dc.dose2016.riocuartobandasderock.dao.impl.SessionManager;
import ar.edu.unrc.exa.dc.dose2016.riocuartobandasderock.dao.impl.SongDaoImpl;
import ar.edu.unrc.exa.dc.dose2016.riocuartobandasderock.model.Song;

import java.util.List;
import spark.Request;
import spark.Response;


/**
 * This Class implements the song controller
 **/


public class SongController {

    private SongDAO songDao;
    private SessionManager session;
 
    
    
    /**
     * Class constructor 
     */
    
    public SongController(){
    	songDao = new SongDaoImpl();
    }
    
    
    /**
     * Get all bands songs
     * @param req
     * @param res
     * @return a list of all bands songs
     */
    
    public List<Song> getAllSongs(Request req, Response res){    
        return songDao.getAllSongs();
    }
    

    
    /**
     * Get all artist songs
     * @param req
     * @param res
     * @return a list of all artist songs
     */  
    
    public List<Song> getArtistSongs (Request req, Response res){
        String artistName = req.params("name");
        return songDao.findByAuthor(artistName);
    }
    
    
    /**
     * Get a specific song by its id
     * @param req
     * @param res
     * @return a song
     */
  
    
    public Song getSongById (Request req, Response res){
    	String songId = req.params(":id");
        return songDao.findById(songId);
    }
    
    /**
     * Get a song by its name
     * @param req
     * @param res
     * @return a song
     */
    
    public List<Song> getSongByName (Request req, Response res){
    	
    	String songName = req.params("name");
    	
    	if (songName == null || songName == ""){
    		res.status(400);
    		return null;
    	}
    	session= SessionManager.getInstance();   	
    	session.openCurrentSession();
    	List<Song> songs = songDao.findByName(songName);
    	session.closeCurrentSession();
    	res.status(songs.size() > 0 ? 200 : 204);
    	return songs;    	
    }
  
    /**
     * Get list of songs by a specific duration  
     * @param req
     * @param res
     * @return
     */
    
    public List<Song> getSongByDuration (Request req, Response res){
    	String duration = req.params("duration");
    	
    	if (duration == null || duration == ""){
    		res.status(400);
    		return null;
    	}
    	session= SessionManager.getInstance();
    	session.openCurrentSession();
    	List<Song> songs = songDao.findByDuration(Integer.parseInt(duration));
    	session.closeCurrentSession();
    	res.status(songs.size() > 0 ? 200 : 204);
    	return songs;
    }
    
    
    /**
     * Add a new song
     * @param req
     * @param res 
     * @return
     */
  
    public String addSong (Request req, Response res){
    	
    	String songName = req.queryParams("name");    	
    	String dur = req.queryParams("duration");    	
    	
    	if(( songName == null || songName == "" ) || dur == null) {
			res.status(400);
			res.body("Invalid content of parameters");
			return res.body();
		}
    	session= SessionManager.getInstance();
    	session.openCurrentSessionwithTransaction();
    	boolean result = songDao.addSong(songName,Integer.parseInt(dur));
    	session.closeCurrentSessionwithTransaction();
    	if(result){
    	res.body("Song created");
    	res.status(201);
    	}
    	return res.body();    		
    }
    
    
    
    /***
	 * This method takes a song from the frontend, and delete this song in database
	 * @param req
	 * @param res
	 * @return true if the song was deleted. Otherwise, false.
	 */
	public String removeSong(Request req,Response res){	
		String id = req.params(":id");
		if ((id == "") ||(id == null)) {
			res.status();
			return "Request invalid";
		}
		session= SessionManager.getInstance();
		session.openCurrentSessionwithTransaction();
	 	boolean status = songDao.removeSong(id);
	 	session.closeCurrentSessionwithTransaction();
		if (status){
			res.status(200);
			return "Success";
		}
		res.status(409);
		return "Fail";

	}
    
   
    

    
}