<?php

namespace App\EventSubscriber;

use App\Entity\Article;
use DateTime;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{
   private $slugger;
   
   private $security;

   public function __construct(SluggerInterface $slugger, Security $security)
   {
      $this->slugger = $slugger;
      $this->security = $security;
   }

   public static function getSubscribedEvents()
   {
      return [
         BeforeEntityPersistedEvent::class => ['setArticleSlugAndDateAndUser'],
      ];
   }

   public function setArticleSlugAndDateAndUser(BeforeEntityPersistedEvent $event)
   {
      $entity = $event->getEntityInstance();

      if (!($entity instanceof Article)) {
         return;
      }

      $slug = $this->slugger->slug($entity->getTitle());
      $entity->setSlug($slug);

      $now = new Datetime('now');
      $entity->setDate($now);

      // $user = $this->security->getUser();
      // $entity->setUser($user);
   }

}