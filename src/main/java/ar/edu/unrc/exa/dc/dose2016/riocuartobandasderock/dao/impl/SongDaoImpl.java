package ar.edu.unrc.exa.dc.dose2016.riocuartobandasderock.dao.impl;

import java.util.LinkedList;
import java.util.List;

import org.hibernate.Session;
import org.hibernate.SessionFactory;
import org.hibernate.Transaction;
import org.hibernate.boot.registry.StandardServiceRegistryBuilder;
import org.hibernate.cfg.Configuration;
import org.hibernate.query.Query;

import ar.edu.unrc.exa.dc.dose2016.riocuartobandasderock.dao.SongDAO;
import ar.edu.unrc.exa.dc.dose2016.riocuartobandasderock.main.ServerOptions;
import ar.edu.unrc.exa.dc.dose2016.riocuartobandasderock.model.Artist;
import ar.edu.unrc.exa.dc.dose2016.riocuartobandasderock.model.Song;

public class SongDaoImpl implements SongDAO{
	
	private Session currentSession;
	
	private Transaction currentTransaction;

	
	@Override
	public List<Song> getAllSongs() {
		List<Song> songList = new LinkedList<>();
		Query<Song> query;
		query = currentSession.createQuery("from Song", Song.class);
		songList.addAll(query.getResultList());
		return songList;
	}
	
	@Override
	public Boolean updateSong(Song song){
		if (song != null) {
			currentSession.update(song);
			return true;
		} else {
			return false;
		}
	}
	@Override   
	public Boolean removeSong(Song song){
		if (song != null) {
			currentSession.delete(song);
			return true;
		} else {
			return false;
		}
	}
	@Override   

	public Boolean addSong(String name,Integer duration){
		boolean result = false;
		if ((name != null && !name.equals("")) || duration != null){
			Song song = new Song(name,duration);
			currentSession.save(song);
			result = true;
		}
		else {
			throw new IllegalArgumentException("the parameters for creating a song can not all be empty or null");
		}
		return result;
	}
	
	@Override
	public Song findById(String id){
		if (id != null && id != "") {
			Song song = currentSession.find(Song.class, id);
			return song;
		} else {
			return null;
		}
	}
	
	@Override
	public List<Song> findByAuthor(String author){
		return null;
	}
	
	@Override
	public List<Song> findByName(String name){
		if (name != null && name != "") {
			Query<Song> query = currentSession.createQuery("from Song where name=:n", Song.class);
			query.setParameter("n", name);
			return query.getResultList();
		} else {
			throw new IllegalArgumentException("the 'name' param for search an song can not be null or empty.");
		}
	}
    	
	@Override
	public List<Song> findByDuration(Integer duration){
		if (duration != null && duration.equals("")) {
			Query<Song> query = currentSession.createQuery("from Song where duration=:n", Song.class);
			query.setParameter("n", duration);
			return query.getResultList();
		} else {
			throw new IllegalArgumentException("the 'duration' param for search an song can not be null or empty.");
		}
	}



}
