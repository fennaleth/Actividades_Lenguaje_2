**Propósito general**

Este código define una clase Database que:

-Se conecta a un servidor MySQL usando PDO.

-Verifica si una base de datos existe y la crea si no.

-Establece una conexión persistente a esa base de datos.

-Muestra mensajes de éxito o error en pantalla.

**Estructura del código**

class Database {
    private $host;
    private $dbName;
    private $userName;
    private $password;
    public $pdo;

-Propiedades privadas: host, dbName, userName, password almacenan los datos de conexión.

-Propiedad pública: pdo expone el objeto PDO para ejecutar consultas desde fuera de la clase.

**Constructor**

    public function __construct(...) {
    ...
        $this->connect();
    }

-Se ejecuta automáticamente al instanciar la clase.

-Inicializa las propiedades con valores por defecto o personalizados.

-Llama al método connect() para iniciar la conexión.

**Método connect()**

    private function connect() {
        try {
    ...
    } catch (PDOException $error) {
    ...
    }
}

-Encapsula la lógica de conexión dentro de un bloque try/catch para manejar errores.

-Paso 1: Conecta al servidor MySQL sin especificar base de datos.

-Paso 2: Ejecuta CREATE DATABASE IF NOT EXISTS para crearla si no existe.

-Paso 3: Establece una conexión definitiva a la base de datos creada.

-Los mensajes echo informan al usuario del estado de cada paso.

**¿Por qué funciona?**


-PDO es una interfaz moderna, segura y orientada a objetos para trabajar con bases de datos.

-CREATE DATABASE IF NOT EXISTS evita errores si la base ya existe.

-PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION permite capturar errores como excepciones.

-Interpolación de variables ({$this->host}) asegura claridad y evita errores de concatenación.

**¿Por qué es óptimo y simplificado?**

-Compacto: Toda la lógica está contenida en una clase con menos de 50 líneas. 

-Reutilizable: Se puede instanciar Database() en cualquier parte del proyecto. 

-Automatizado: Crea la base de datos si no existe, sin intervención manual. 

-Seguro: Usa PDO con manejo de errores correctamente. 

-Escalable: Se puede extender la clase para crear tablas, ejecutar consultas, etc.