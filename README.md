# geolocalizacionIPs
Proyecto de geolocalización de direcciones IPs

## Pasos para ejecutar el proyecto

1. Descargar el proyecto desde GitHub

```
git clone https://github.com/miki0892/geolocalizacionIPs.git

```

2. Posicionarse en el directorio "geolocalizacionIPs"

```
cd geolocalizacionIPs

```

3. Buildear y levantar los contenedores de docker

```
docker-compose up -d --build

```

4. Ingresar al contenedor de php

```
docker exec -it geolocalizacionips_php_1 bash

```

5. Instalar las dependencias del proyecto

```
composer install

```

6. Correr las migraciones para crear la estructura de la base de datos

```
php bin/console doctrine:migrations:migrate

```

7. Ingresar algunas de las siguientes urls en algún navegador:
	- Consulta de geolocalizacion: [http://localhost:8001/geolocalizacion](http://localhost:8001/geolocalizacion) 
	- Consulta de estadisticas: [http://localhost:8001/geolocalizacion/estadisticas](http://localhost:8001/geolocalizacion/estadisticas)  

## Detalle técnico

Se eligieron las siguientes herramientas para realizar el proyecto:
 - Nginx como servidor web 
 - Php como lenguaje de programación
 - Symfony como framework web
 - Mysql como motor de base de datos
 - Docker como herramienta de virtualización
 - Composer como gestionador de dependencias

Consideraciones:
 - Las IPs pueden ser versión 4 o 6. Se validará el formato de las mismas al consultar la geolocalización.
 - Cada vez que se consulte información en las APIs se guardarán los datos en la base. De esta manera, si se consulta la geolocalización de una IP ya consultada anteriormente, los datos serán obtenidos desde la base de datos y se evitará hacer llamadas innecesarias a los servicios.
 - Se utiliza Nginx como servidor web ya que es más performante que Apache soportando de esta manera mayor tráfico. Para soportar mayor tráfico se debería optar por una estructura clusterizada.

