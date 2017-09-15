<?php

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Page;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadPageData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $pages = [];

        // homepage Default Info
        $temp = new Page();
        $temp
            ->setPageName('homepage')
            ->setTitle('')
            ->setBgImage('images/PhotoGrid_1502079214852.jpg')
            ->setHeader('A Green Oil Life')
            ->setSubheader('A green way to improve your life.')
            ->setContent(<<<EOT
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <h2><a href="#" data-toggle="modal" data-target="#sampleModal">Free Samples Here!</a></h2>
        </div>
    </div>
    <div>&nbsp;</div>
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <h2>Mission Statement</h2>
            <p>At A Green Oil Life, our mission is to provide support to anyone seeking a more balanced, healthy lifestyle while also providing an excellent business opportunity to gain time and financial freedom. Join me as we journey through clean eating, simple exercise plans, essential oil applications, and most importantly, accountability and mentorship.</p>
        </div>
    </div>
EOT
)
        ->setFlags('testimonials');
        $pages[] = $temp;

        // about_me Default Info
        $temp = new Page();
        $temp
            ->setPageName('about_me')
            ->setTitle('About Me | ')
            ->setBgImage('images/about-me-bg.jpg')
            ->setHeader('About Me')
            ->setSubheader('Here is what I\'m about')
            ->setContent(<<<EOT
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <p>Nicole Green is a full time DoTerra International Wellness Advocate and business owner of A Green Oil Life. She is all about finding balance in your life and focused on mental and a physical healthy lifestyle as well as green living.</p>
            <p>As a former project coordinator for Response Team 1 renovation company, Nicole is a expert at organizing and managing projects including accounts receivable.</p>
            <p>Nicole is also a certified cosmetologist from Euphoria Institute. As a former bartender of six years at local bars in Las Vegas making her accessible with the ability to communicate with business associates and customers.</p>
            <p>Nicole lives in Las Vegas, NV with her husband, Joey Green, their new baby girl, Orissa Green, and their playful border collie Ike. Nicole enjoys hiking, camping, and relaxing in nature, preferably with a glass of wine. She is extremely business oriented and will help you reach your full potential.​</p>
        </div>
    </div>
EOT
            );
        $pages[] = $temp;

        // go_green Default Info
        $temp = new Page();
        $temp
            ->setPageName('go_green')
            ->setTitle('Go Green | ')
            ->setBgImage('images/contact-bg.jpg')
            ->setHeader('Go Green')
            ->setSubheader('Follow me!')
            ->setContent(<<<EOT
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto"><!-- PLACE NEW POSTS AFTER THIS LINE -->
            <div class="post-preview">
                <h2 class="post-title">
                  The title of the post goes here
                </h2>
                <h3 class="post-subtitle">
                  Put a subtitle here, if you want. If not, remove the line above and below.
                </h3>
                <p>
                  This is where the body of the post goes. If you want multiple paragraphs, wrap them in th "p" tags like this one is.
                </p>
                <p>
                  Like this
                </p>
            </div>
        </div>
    </div>
<!--
            <div class="post-preview">
                <h2 class="post-title">
                  The title of the post goes here
                </h2>
                <h3 class="post-subtitle">
                  Put a subtitle here, if you want. If not, remove the line above and below.
                </h3>
                <p>
                  This is where the body of the post goes. If you want multiple paragraphs, wrap them in th "p" tags like this one is.
                </p>
                <p>
                  Like this
                </p>
            </div>
            <hr>
-->
EOT
            );
        $pages[] = $temp;

        // essential_oils Default Info
        $temp = new Page();
        $temp
            ->setPageName('essential_oils')
            ->setTitle('Essential Oils | ')
            ->setBgImage('images/contact-bg.jpg')
            ->setHeader('Essential Oils')
            ->setSubheader('Oil Information!')
            ->setContent(<<<EOT
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item"src="https://www.youtube.com/embed/E-nOQyex3o4" frameborder="0" allowfullscreen></iframe>
            </div>
            <div>&nbsp;</div>
            <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item"src="https://www.youtube.com/embed/Wf6s3r2_JkU" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
    </div>
EOT
            );
        $pages[] = $temp;

        // events Default Info
        $temp = new Page();
        $temp
            ->setPageName('events')
            ->setTitle('Events | ')
            ->setBgImage('images/post-bg.jpg')
            ->setHeader('Events')
            ->setSubheader('Join me in these upcoming events!')
            ->setContent(<<<EOT
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <p>Check back often for new events and get moving!</p>
        </div>
    </div>
EOT
            )
            ->setFlags('events');
        $pages[] = $temp;

        // contact Default Info
        $temp = new Page();
        $temp
            ->setPageName('contact')
            ->setTitle('Contact | ')
            ->setBgImage('images/homepage-bg.jpg')
            ->setHeader('Contact')
            ->setSubheader('Have questions? I have answers (maybe).')
            ->setContent(<<<EOT
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <p>Want to get in touch with me? Fill out the form below to send me a message and I will try to get back to you within 24 hours!</p>
        </div>
    </div>
EOT
            )
            ->setFlags('contact_form');
        $pages[] = $temp;

        foreach ($pages as $page) {
            $manager->persist($page);
        }
        $manager->flush();
    }
}