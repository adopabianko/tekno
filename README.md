# Instalasi via Docker

Clone project:
```bash
$ git clone https://github.com/adopabianko/tekno.git
```



### Proses Instalasi CMS

Jalankan perintah berikut di command line:

```bash
$ cd cms
```

```bash
$ cp -R .env.example .env
```

```bash
$ ./vendor/bin/sail up -d
```

```bash
$ ./vendor/bin/sail artisan migrate
```

```bash
./vendor/bin/sail artisan db:seed
```

Akses Url http://localhost:8484



### Proses Instalasi API

Jalankan perintah berikut di command line:

```bash
$ cd ../api
```

```bash
$ cp -R .env.example .env
```

```bash
$ npm install
```

```bash
$ docker-compose up -d
```

Akses Url http://localhost:3434


#### Akses API

Untuk mengakses api dibutuhkan sebuah token sebagai paramater di header request yang di generate otomatis oleh sistem, jalankan perintah berikut untuk mendapatkan token :

```bash
$ node console generatetoken
```

<p align="center">
  <a href="#"><img alt="flip" src="https://user-images.githubusercontent.com/8348927/103527645-421a5080-4eb5-11eb-8281-3a86aa84b5ec.png" width="1000"/></a>
</p>

<p align="center">
  <a href="#"><img alt="flip" src="https://user-images.githubusercontent.com/8348927/103528368-6c204280-4eb6-11eb-9a80-cfe5880a94c1.png" width="1000"/></a>
</p>


#### Endpoint API :

<table>
  <thead>
    <tr>
      	<th>Name</th>
      	<th>URL</th>
      	<th>Method</th>
    </tr>
  </thead>
  <tbody>
    <tr>
        <td>All Posts</td>
      	<td>http://localhost:3434/post</td>
      	<td>GET</td>
    </tr>
      <tr>
     	<td>Post By Category</td>
        <td>http://localhost:3434/post?category=gadget</td>
        <td>GET</td>
      </tr>
      <tr>
        <td>Post Categories</td>
      	<td>http://localhost:3434/post/category</td>
      	<td>GET</td>
    </tr>
      <tr>
        <td>Post Tags</td>
      	<td>http://localhost:3434/post/tag</td>
      	<td>GET</td>
    </tr>
  </tbody>
</table>

