# Dashboard Gestión Codelium

Este repositorio corresponde al proyecto de forjad de artilugios, Ganador del concurso de mi 1ra Web

## Consideraciones para trabajar en GitHub

1. **Clonar este repositorio en tu entorno local**  
   Clona el repositorio dentro de la carpeta `htdocs` (XAMPP) o `www` (WAMP).

    ```bash
    git clone https://github.com/Codelium-team/forjadeartilugios.git
    ```

2. **Cada tarea debe tener una rama creada**

    ```bash
    git checkout -b nombre_de_la_rama
    ```
    
3. **Al crear cada rama actualizar los cambios que puedan existir en la rama develop**   
    
    ```bash
    git pull origin develop
    ```

4. **El formato para la creación de tareas es el siguiente idtarea_nombreInicialApellido_tipodetarea(feat o fix)**   

    Ej: git checkout -b 01_fabianD_feat

5. **Los commits que sean lo mas claros y descriptivos posibles**   

6. **Subir tu rama a github, no a la rama develop. Luego accedo al repositorio y genero mi pull request**   

    ```bash
    git push -u origin nombre_de_la_rama
    ``` 

7. **Todos los pull request se realizaran a la rama develop, una vez que exista una version estable se generará el merge a main**

## Consideraciones del proyecto

1. **El archivo de conexiones.php solo se trabajara con credenciales locales**

2. **Implementar Base de datos con el archivo forjadeartilugios.sql**

3. **Respetar distribución de carpetas para la organización del codigo**

## Librerias a utilizar

1. **Mensajes de alertas en pantalla**

https://sweetalert2.github.io/

2. **Biblioteca de Iconos**

https://icons.getbootstrap.com/








