package ar.edu.unrc.exa.dc.dose2016.riocuartobandasderock.dao.impl;

import java.util.List;

import ar.edu.unrc.exa.dc.dose2016.riocuartobandasderock.model.Song;
import ar.edu.unrc.exa.dc.dose2016.riocuartobandasderock.dao.SongDAO;

public class SongDaoImpl implements SongDAO{

	public List<Song> getAllSongs(){
		return null;
	}
	   
	public Boolean updateSong(Song song){
		return false;
	}
	   
	public Boolean removeSong(Song song){
		return false;
	}
	   
	public Boolean addSong(Song song){
		return false;
	}
	
	public Song findById(String id){
		return null;
	}
	
	public List<Song> findByBandName(String BandName){
		return null;
	}
	
	public List<Song> findByName(String name){
		return null;
	}
                    
    public List<Song> findByGenere(String genere){
    	return null;
    }
                    
    public List<Song> findByAuthor(String author){
    	return null;
    }
                    
    public List<Song> findByAlbum(String album){
    	return null;
    }
	
	public List<Song> findByDuration(int duration){
		return null;
	}



}
