# CAMBIOS DE TABLAS Y/O NOTAS ALENKA

1. Se agrego a la tabla **despachos** una columna de:

| nombre | tipo | nulo |
|---|---|---|
| sabor | VARCHAR(255) | no |

2. Nueva tabla llamada **pre_salida_molino**

| nombre | tipo | nulo | pk | fk | comentario |
|---|---|---|---|---|---|
| id | INT UNSIGNED |  | si | |
| codigo | VARCHAR(255) | si |
| fecha | DATE | si | |
| turno | VARCHAR(255) | SI | | | puede ser MAÑANA o TARDE 
| id_encargado | INT UNSIGNED | | | si | es el que recibe la mezcla a  **users**
| proceso_id | INT UNSIGNED | si | | si | a la tabla **procesos**
| observacion | VARCHAR(255) | si | | | observaciones de entrega
| baldes | INT |  | | | la cantidad de baldes que recibe
| cantidad | INT |  | | | la cantida dek producto recibido en kilogramos
| id_user | INT UNSIGNED |  | | si | usuario que la ultima vez hizo cambios
| estado | TINYINT | | | | puede ser 1 o 0
