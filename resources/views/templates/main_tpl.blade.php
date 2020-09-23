<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <meta property="og:type"  content="article" />
    <meta name="twitter:card" content="summary_large_image">

    <meta name="description" content="Personal Website / Portfolio">
    <meta property="og:description"  content="Personal Website / Portfolio" />
    <meta property="og:title" content="John Mark Mancol" />
    <meta property="og:image" content="{{ asset('images/profile.png') }}" />
    <meta property="og:image:width" content="600" />
    <meta property="og:image:height" content="600" />

    <title>Juan Marcos</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap"
      rel="stylesheet"
    />
    <link href="{{ asset('css/all.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('style.css') }}" />
  </head>
  <body>
    <div class="main-content">
      @include('includes/sidebar')
      <div class="content">
        <ul class="navigations">
          <li>
            <a href="/" class="active">PROJECTS</a>
          </li>
          <li>
            <a href="/tools">TOOLS</a>
          </li>
          <li>
            <a href="/skills">SKILLS</a>
          </li>
        </ul>
        @yield('content')
      </div>
    </div>
    <div id="popupwrapper">
        <div id="project-info-content">
            <h2 id="project-title"></h2>
            <p id="project-description"></p>
        </div>
    </div>
    <script src="jQuery.min.js"></script>
    <script src="script.js"></script>
  </body>
</html>
