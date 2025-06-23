<!DOCTYPE html>
<html>
<head>
    <title>Blogs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<style>

body {
  margin: 0;
  padding: 0;
  font-family: Arial, sans-serif;
}


.pagination svg {
    width: 1em;
    height: 1em;
    vertical-align: middle;
    fill: currentColor;
}

.sidebar-left {
  position: fixed;
  left: 0;
  top: 0;
  bottom: 0;
  width: 200px;
  background-color: #333;
  color: white;
  padding: 1rem;
}

.sidebar-right {
  position: fixed;
  right: 0;
  top: 0;
  bottom: 0;
  width: 500px;
  background-color: #444;
  color: white;
  padding: 1rem;
}

.sidebar-top {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  height: 100px;
  background-color: #555;
  color: white;
  padding: 1rem;
}

.sidebar-bottom {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  height: 60px;
  background-color: #666;
  color: white;
  padding: 1rem;
}

.contenido {
  position: absolute;
  top: 40%px; 
  bottom: 40%px;
  left: 0px;
  right: 360px;
  background-color: white;
  padding: 1rem;
  min-height: 95%
}


.tags {
  position: fixed;
  top: 100px;
  bottom: 60px;
  right: 0;
  width: 300px;
  background-color: #f4f4f4;
  padding: 1rem;
  overflow: auto;
}

img {
    max-width: 175px;
    min-width: 175px;
    max-height: 175px;
    min-height: 175px;
}

.center{
    text-align: center;
  font-size: 60px;
  line-height: 80px; 
  justify-content: 80px;
  margin: 0;
}

table, th, td, tr {
  border: 1px solid black;
}
th, td, tr {
  background-color: #8c8c8c;
  padding: 15px;
  max-width: 220px;
  min-width: 220px;
}

a {
  color: inherit;
  text-decoration: none; 
}

a:hover {
  color: skyblue;
}

.descripcion {
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
  max-width: 1000px;
  word-break: break-word;
  white-space: normal;
  overflow-wrap: break-word;
}

ul {
  position: fixed;
  overflow: hidden;
  padding: 0;
  background-color: #333;
  top: 0;
  z-index: 1000;
}

li {
  float: left;
}

li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

li a:hover {
  background-color: #111;
}

</style>
      <body>
      </body>
</html>