# 🚢 Neumatruck - Laravel - Docker

Manual Proyecto NEUMATRUCK con Laravel y Docker  
> ⚠️ **Advertencia:** este contenedor no ejecuta las migraciones, ya que la base de datos fue tomada por la versión anterior con PHP 5.


![Neumatruck  Laravel](https://i.ibb.co/tTYDVBBP/images.png)

---

## 📦 Estructura del Proyecto

```
📁 neumatruck/
├── docker-compose.yml
└── README.md
```

---

## 🧰 Requisitos

- [Docker](https://www.docker.com/get-started)  
 - Navegador web

---

## 🚀 ¿Cómo empezar?

1. **Clona el repositorio:**

```bash
git clone git@github.com:Taoista/neumatruck-laravel.git
cd neumatruck
```

2. **Levanta los contenedores:**

```bash
docker-compose up -d
```

3. **Accede a PHPMyAdmin:**

📍 [http://localhost:8003](http://localhost:8003)
-  Esto esta conectado a otro contenedor que contiene la base de datos debes configurarlo
- **Servidor:** `db`  
- **Usuario:** `taoista`  
- **Contraseña:** `7340458`

---

## ⚙️ Contenido del archivo `docker-compose.yml`

```yaml
version: '3.8'

services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: laravel_app
    working_dir: /var/www/html
    volumes:
      - .:/var/www/html
    networks:
      - laravel

  web:
    image: nginx:alpine
    container_name: laravel_web
    ports:
      - "8003:80"
    volumes:
      - .:/var/www/html
      - ./nginx.conf:/etc/nginx/conf.d/default.conf
    depends_on:
      - app
    networks:
      - laravel


volumes:
  dbdata:

# conexion a otro contenedor
networks:
  laravel:
    external: true

```

---

## 🧼 Comandos útiles

| Acción                        | Comando                                 |
|------------------------------|-----------------------------------------|
| Ver contenedores activos     | `docker ps`                             |
| listados en los contenedores conectados a esa red.| `docker network inspect laravel`                |
| crea la red para la conexion         | `docker network create laravel`                   |
| Eliminar volumen persistente | `docker volume rm tu-repo_db_data`      |

---



## 📒 Notas

- Puedes conectar cualquier cliente MySQL o aplicación PHP usando:
  - **Host:** `db`
  - **Puerto:** `3306`
  - **Usuario:** `taoista`
  - **Contraseña:** `7340458` 
- Desde otros contenedores, el host debe ser `db` (nombre del servicio).

---

## 🧑‍💻 Autor

Creado con ❤️ por [Alberto Olave (DevTao)](https://github.com/Taoista)
mi web (alberto-olave.cl)](https://alberto-olave.cl)

---


