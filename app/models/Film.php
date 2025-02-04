<?php

class Film
{
  public static function getRecentFilms($limit)
  {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM films ORDER BY id DESC LIMIT :limit");
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public static function getFilmsBySemester($semestre)
  {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM films WHERE semestre = :semestre ORDER BY id DESC");
    $stmt->bindParam(':semestre', $semestre, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public static function getAllSemesters($limit = null)
  {
    global $pdo;
    $query = "SELECT DISTINCT semestre FROM films ORDER BY semestre DESC";
    if ($limit) {
        $query .= " LIMIT :limit";
    }
    $stmt = $pdo->prepare($query);
    if ($limit) {
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
  }

  public static function getAllFilms()
  {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM films ORDER BY id DESC");
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public static function getById($id)
  {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM films WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch();
  }

  public static function getWithTMDBData($id)
  {
    global $pdo, $tmdbService;

    $stmt = $pdo->prepare("SELECT * FROM films WHERE tmdb_id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $film = $stmt->fetch();

    if ($film) {
      $tmdbData = $tmdbService->getMovieDetails($id);
      if (!empty($tmdbData)) {
        $film['title'] = $tmdbData['title'];
        $film['poster_path'] = $tmdbService->getImageUrl($tmdbData['poster_path'], "w500");
        $film['overview'] = $tmdbData['overview'];
        $film['backdrop_path'] = $tmdbService->getImageUrl($tmdbData['backdrop_path']);
        $film['release_date'] = mb_substr($tmdbData['release_date'], 0, 4);
        $directors = [];
        foreach ($tmdbData['credits']['crew'] as $crewMember) {
          if ($crewMember['job'] === 'Director') {
            $directors[] = $crewMember['name'];
          }
        }
        $directorsString = implode(', ', $directors);
        $film['directors'] = $directorsString;
      }
    }

    return $film;
  }
}
