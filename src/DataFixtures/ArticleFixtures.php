<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends BaseFixture
{
    private static $articleTitles = [
        'Why Selfish People Are Selfish',
        'Life is Boring, Get Use to It',
        'It Never Gets Any Easier Always'
    ];

    private static $articleImages = [
        'asteroid.jpeg',
        'mercury.jpeg',
        'lightspeed.png'
    ];

    private static $articleAuthors = [
        'Mike Ferengi',
        'Amy Oort'
    ];

    /**
     * @param ObjectManager $manager
     * @return mixed|void
     */
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Article::class, 10, function (Article $article, $count) use ($manager) {
            $article->setTitle($this->faker->randomElement(self::$articleTitles))
                ->setContent('One morning, when **Gregor Samsa woke from troubled dreams**, he found himself transformed in his bed into a horrible vermin. *He lay on his armour-like back, and if he lifted his head a little* 

            he could see his brown belly, slightly domed and divided by arches into stiff sections. The bedding was hardly able to cover it and seemed ready to slide off any moment.
            
            His many legs, pitifully thin compared with the size of the rest of him, waved about helplessly as he looked. "What\'s happened to me?" he thought. It wasn\'t a dream. His room, a 
            
            proper human room although a little too small, [lay peacefully between its four](http://localhost:8080/news/why-selfish-people-are-selfish-176) familiar walls. A collection of textile samples lay spread out on the table - Samsa was a 
            
            travelling salesman - and above it there hung a picture that he had recently cut out of an illustrated magazine and housed in a nice, gilded frame. It showed a lady fitted out with a 
            
            fur hat and fur boa who sat upright, raising a heavy fur muff that covered the whole of her lower arm towards the viewer. Gregor then turned to look out the window at the dull weather. 
            
            Drops of rain could be heard hitting the pane, which made him feel quite sad. "How about if I sleep a little bit longer and forget all this nonsense", he thought, but that was something he was unable to do 
            
            because he was used to sleeping on his right, and in his present state couldn\'t get into that position.');

            $article->setAuthor($this->faker->randomElement(self::$articleAuthors))
                ->setHeartCount($this->faker->numberBetween(6, 89))
                ->setImageFileName($this->faker->randomElement(self::$articleImages));

            $comment1 = new Comment();
            $comment1->setAuthorName('Mike Furangandi')
                ->setContent('How about if I sleep a little bit longer and forget all this nonsense');
            //$comment1->setArticle($article);
            $manager->persist($comment1);

            $comment2 = new Comment();
            $comment2->setAuthorName('Dan McHughes')
                ->setContent('The bedding was hardly able to cover it and seemed ready to slide off any moment');
            //$comment2->setArticle($article);
            $manager->persist($comment2);

            $article->addComment($comment1);
            $article->addComment($comment2);

            // publish most articles
            if ($this->faker->boolean(70)) {
                $article->setPublishedAt($this->faker->dateTimeBetween('-50 days', '-1 days'));
            }
        });
        $manager->flush();
    }
}