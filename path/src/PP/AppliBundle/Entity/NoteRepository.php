<?php

namespace PP\AppliBundle\Entity;

use Doctrine\ORM\EntityRepository;

use PP\UserBundle\Entity\Utilisateur;
use PP\AppliBundle\Entity\Recette;

/**
 * NoteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NoteRepository extends EntityRepository
{
	public function noteGenerale($recette)
	{
		return $this->getEntityManager()
            ->createQuery(
                "SELECT AVG(n.note) AS note FROM PPAppliBundle:Note n WHERE IDENTITY(n.recette) LIKE :recette"
            )->setParameter('recette', '%'.$recette->getId().'%')
            ->getSingleResult();
	}
}
