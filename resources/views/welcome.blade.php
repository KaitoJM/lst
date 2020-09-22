<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <meta property="og:type"  content="article" />
    <meta name="twitter:card" content="summary_large_image">

    <meta name="description" content="Test Description">
    <meta property="og:description"  content="Test Description" />
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
      <div class="side-bar">
        <div class="main-information">
          <img src="{{ asset('images/profile.png') }}" class="profile-photo" />
          <h1>John Mark Mancol</h1>
          <p>FULL STACK WEB DEVELOPER</p>
          <p>
            <i class="icon fas fa-map-marker-alt"></i> Amampacang, Calbayog
            City, Samar
          </p>
        </div>
        <div class="description">
          <p>
            <i class="icon fas fa-quote-left"></i>
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quod nisi
            corporis est officia neque voluptatem molestias dolore, natus vero.
            Nulla quis ducimus quod ad delectus beatae dolorum ipsam unde est.
          </p>
        </div>
        <div class="timeline">
          <h3>TIMELINE</h3>
          <ul>
            <li>
              <b>2018 FULL STACK WEB DEVELOPER</b>
              <p>Qonvex Technology. Brgy. Obrero Calbayog City.</p>
            </li>
            <li>
              <b>2015 BACKEND WEB DEVELOPER</b>
              <p>Rootplus Technology. Brgy. Carmen Calbayog City.</p>
            </li>
          </ul>
        </div>
      </div>
      <div class="content">
        <ul class="navigations">
          <li>
            <a href="#" class="active">PROJECTS</a>
          </li>
          <li>
            <a href="#">TOOLS</a>
          </li>
          <li>
            <a href="#">SKILLS</a>
          </li>
        </ul>
        <section class="project-container">
          <div class="project-grid">
            <div class="item">
              <img src="{{ asset('images/theNinth.png') }}" alt="" />
              <div class="project-description">
                <h4>TheNinth (2020)</h4>
                <p>
                  An online comics / manga reading website also allows you to
                  upload your own story.
                </p>
              </div>
            </div>
            <div class="item">
              <img src="{{ asset('images/capfrance.png') }}" alt="" />
              <div class="project-description">
                <h4>Capfrance (2019)</h4>
                <p>
                  Cap France is the leading operator of holiday villages for
                  associative tourism in France .
                </p>
              </div>
            </div>
            <div class="item">
              <img src="{{ asset('images/interfaceConcept.png') }}" alt="" />
              <div class="project-description">
                <h4>Interface Concept (2016)</h4>
                <p>
                  INTERFACE CONCEPT is a leader in design and manufacturing of
                  high-performance embedded boards and systems, aimed at ground,
                  naval, air and industrial applications.
                </p>
              </div>
            </div>
            <div class="item">
              <img src="{{ asset('images/wearebaddies.png') }}" alt="" />
              <div class="project-description">
                <h4>WeAreBaddies (2017)</h4>
                <p>
                  Released in 2017, We Are Baddies is a subversive ready to wear
                  clothing brand which cerebrates the French’s know how.
                </p>
              </div>
            </div>
            <div class="item">
              <img src="{{ asset('images/ceilivtv.png') }}" alt="" />
              <div class="project-description">
                <h4>Ceiliv TV (2015)</h4>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
              </div>
            </div>
            <div class="item">
              <img src="{{ asset('images/hydrofibi.png') }}" alt="" />
              <div class="project-description">
                <h4>HydroFibi (2018)</h4>
                <p>
                  Marc Thomas, former high-level athlete and holder of a STAPS
                  pro license, uses his many years of professional experience as
                  a teacher of aquatic...
                </p>
              </div>
            </div>
            <div class="item">
              <img src="{{ asset('images/ndg.png') }}" alt="" />
              <div class="project-description">
                <h4>NDG (2017)</h4>
                <p>
                  N.D.G - for nid de guêpes*, meaning " the wasp nest " -
                  designs and produces collections meshing both american
                  workwear culture and french high-end sensibilities.
                </p>
              </div>
            </div>
            <div class="item">
              <img src="{{ asset('images/guichard.png') }}" alt="" />
              <div class="project-description">
                <h4>Guichard (2017)</h4>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
              </div>
            </div>
            <div class="item">
              <img src="{{ asset('images/guichardplanning.png') }}" alt="" />
              <div class="project-description">
                <h4>Guichard Planning (2017)</h4>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
              </div>
            </div>
          </div>
        </section>
        <section class="tool-container hidden">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Officia eum
          illo, odio at tenetur iusto expedita porro, perferendis rerum minus
          maxime inventore facere fugiat nihil consequatur! Facilis laborum
          autem pariatur!
        </section>
        <section class="skill-container hidden">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Officia eum
          illo, odio at tenetur iusto expedita porro, perferendis rerum minus
          maxime inventore facere fugiat nihil consequatur! Facilis laborum
          autem pariatur!
        </section>
      </div>
    </div>
  </body>
</html>
