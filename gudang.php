<?php
class Gudang {
    private $conn;
    public $id;
    public $name;
    public $location;
    public $capacity;
    public $status;
    public $opening_hour;
    public $closing_hour;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Metode untuk menambahkan gudang baru
    public function create() {
        $query = "INSERT INTO gudang (name, location, capacity, status, opening_hour, closing_hour) 
                  VALUES (:name, :location, :capacity, :status, :opening_hour, :closing_hour)";

        $stmt = $this->conn->prepare($query);

        // Mengikat parameter
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':location', $this->location);
        $stmt->bindParam(':capacity', $this->capacity);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':opening_hour', $this->opening_hour);
        $stmt->bindParam(':closing_hour', $this->closing_hour);

        return $stmt->execute();
    }

    // Metode untuk memperbarui gudang
    public function update() {
        $query = "UPDATE gudang SET name = :name, location = :location, capacity = :capacity, 
                  status = :status, opening_hour = :opening_hour, closing_hour = :closing_hour 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Mengikat parameter
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':location', $this->location);
        $stmt->bindParam(':capacity', $this->capacity);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':opening_hour', $this->opening_hour);
        $stmt->bindParam(':closing_hour', $this->closing_hour);

        return $stmt->execute();
    }

    // Metode untuk mengambil data gudang berdasarkan ID
    public function readOne() {
        $query = "SELECT name, location, capacity, status, opening_hour, closing_hour 
                  FROM gudang WHERE id = :id LIMIT 0,1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        // Ambil hasil
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties
        $this->name = $row['name'];
        $this->location = $row['location'];
        $this->capacity = $row['capacity'];
        $this->status = $row['status'];
        $this->opening_hour = $row['opening_hour'];
        $this->closing_hour = $row['closing_hour'];
    }

    // Metode untuk mengambil semua gudang
    public function read($keyword = null) {
        $query = "SELECT id, name, location, capacity, status, opening_hour, closing_hour FROM gudang";
        if ($keyword) {
            $query .= " WHERE name LIKE :keyword";
        }
        $stmt = $this->conn->prepare($query);
        
        if ($keyword) {
            $keyword = "%{$keyword}%";
            $stmt->bindParam(':keyword', $keyword);
        }
        
        $stmt->execute();
        return $stmt; // Mengembalikan hasil query
    }

    // buat delete 

    public function delete() {
        // Query SQL untuk menghapus data dari tabel gudang berdasarkan id
        $query = "DELETE FROM gudang WHERE id = :id";
    
        // Persiapkan query
        $stmt = $this->conn->prepare($query);
    
        // Mengikat parameter id ke query
        $stmt->bindParam(':id', $this->id);
    
        // Eksekusi query
        return $stmt->execute();
    }
    
    // Metode untuk memperbarui status gudang
    public function updateStatus() {
    $query = "UPDATE gudang SET status = :status WHERE id = :id";
    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(':status', $this->status);
    $stmt->bindParam(':id', $this->id);

    return $stmt->execute();
}
}
?>
