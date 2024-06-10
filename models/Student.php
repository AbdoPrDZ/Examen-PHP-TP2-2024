<?php

/**
 * Student - Manage CURD function of table students
 */
class Student {

  /**
   * Create Student instance
   * 
   * @param int | null $id the student id
   * @param string $first_name the student first name
   * @param string $last_name the student last name
   * @param string $gender the student gender
   * @param string $birth_date the student birth date
   */
  public function __construct(
    public int | null $id,
    public string $first_name,
    public string $last_name,
    public string $gender,
    public string $birth_date,
  ) {}
  
  /**
   * Create Student instance from array
   *
   * @param array $data the student array data
   * @return Student the student instance
   */
  static function fromArray(array $data): Student {
    return new Student(
      $data['id'],
      $data['first_name'],
      $data['last_name'],
      $data['gender'],
      $data['birth_date'],
    );
  }

  /**
   * Create array of Student instance from array of arrays
   *
   * @param array $items the array of arrays
   * @return Student[] the array of Student instances
   */
  static function allFromArray(array $items): array {
    $Students = [];

    foreach($items as $item) 
      $Students[] = Student::fromArray($item);

    return $Students;
  }
  
  /**
   * Insert the Student instance to students table
   *
   * @param PDO $pdo the pdo connection
   * @param Student $Student the Student instance
   * @return int | null the inserted student id if success or null
   */
  static function create(PDO $pdo, Student $Student): int | null {
    $query = "INSERT INTO `students` (`first_name`, `last_name`, `gender`, `birth_date`) VALUES (?, ?, ?, ?)";

    $prep = $pdo->prepare($query);

    if ($prep->execute([
      $Student->first_name,
      $Student->last_name,
      $Student->gender,
      $Student->birth_date,
    ])) return $pdo->lastInsertId();
    
    return null;
  }

  /**
   * Update the student row with the new student details
   *
   * @param PDO $con the pdo connection
   * @return boolean true if success otherwise false
   */
  function update(PDO $con): bool {
    $query = "UPDATE `students` SET `first_name` = ?, `last_name` = ?, `gender` = ?, `birth_date` = ? WHERE `id` = ?";

    return $con->prepare($query)->execute([
      $this->first_name,
      $this->last_name,
      $this->gender,
      $this->birth_date,
      $this->id,
    ]);
  }

  /**
   * Find the student row from find and find by column and convert it to Student instance from id
   *
   * @param PDO $pdo the pdo connection
   * @param mixed $find the find value
   * @param string $findBy the column name
   * @return Student | null the Student instance if is exists or null of not
   */
  static function find(PDO $pdo, mixed $find, string $findBy = 'id'): Student | null {
    $query = "SELECT * FROM `students` WHERE `$findBy` = :find";

    $prep = $pdo->prepare($query);
    $prep->bindParam(':find', $find, PDO::PARAM_STR);
    $prep->execute();

    $collection = $prep->fetch(PDO::FETCH_ASSOC);

    if ($collection)
      return Student::fromArray($collection);

    return null;
  }

  /**
   * Get the Student instances by where query
   * 
   * @param PDO $pdo the pdo connection
   * @param string | array | null $where the where query if is string or array of where items or null
   * @param string $whereMerge the merge type of where items (OR, AND)
   * @param string | null $orderBy the order by column
   * @param string $orderType the order type (ASC, DESC)
   * @return Student[] the array of Student instances
   */
  static function where(PDO $pdo, string | array | null $where = null, string $whereMerge = 'AND', string | null $orderBy = null, string $orderType = "ASC") {
    $query = "SELECT * FROM `students`";

    if ($where && is_string($where))
      $query .= $where;
    else if ($where && is_array($where)) {
      $query .= "WHERE ";
      $items = [];

      foreach($where as $item)
        $items[] =  "{$item[0]} {$item[1]} {$item[2]}";
      
      $query .= implode(" $whereMerge ", $items);
    }

    if ($orderBy)
      $query .= " ORDER BY `$orderBy` $orderType";

    $collection =  $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);

    return Student::allFromArray($collection);
  }

  /**
   * Get all Student instances
   * 
   * @param PDO $pdo the pdo connection
   * @param string | null $orderBy the order by column
   * @param string $orderType the order type (ASC, DESC)
   * @return Student[] the array of Student instances
   */
  static function all(PDO $pdo, string | null $orderBy = null, string $orderType = "ASC") {
    return Student::where($pdo, null, 'AND', $orderBy, $orderType);
  }

  /**
   * Search for students by search text
   * 
   * @param PDO $pdo the pdo connection
   * @param string $text the search text
   * @param string | null $orderBy the order by column
   * @param string $orderType the order type (ASC, DESC)
   * @return Student[] the array of Student instances
   */
  static function search(PDO $pdo, string $text, string | null $orderBy = null, string $orderType = "ASC") {
    return Student::where($pdo, [
      ['`first_name`', 'LIKE', "'%$text%'"],
      ['`last_name`', 'LIKE', "'%$text%'"],
      ['`gender`', 'LIKE', "'%$text%'"],
      ['`birth_date`', 'LIKE', "'%$text%'"],
    ], 'OR', $orderBy, $orderType);
  }

  /**
   * Remove the student from table by id
   *
   * @param PDO $pdo
   * @param integer $id the student id
   * @return boolean true if success otherwise false
   */
  static function remove(PDO $pdo, int $id): bool {
    $query = "DELETE FROM `students` WHERE `id` = :id";
    
    $prep = $pdo->prepare($query);
    $prep->bindParam(':id', $id, PDO::PARAM_STR);
    return $prep->execute();
  }

  /**
   * Delete this Student from table by his id
   *
   * @param PDO $pdo
   * @return boolean true if success otherwise false
   */
  function delete(PDO $pdo) {
    return Student::remove($pdo, $this->id);
  } 

}

## karmer_7171@gmail.com