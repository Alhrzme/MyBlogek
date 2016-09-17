<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class TagRepository extends EntityRepository
{
    public function getTagsByNameArray($tagNameArray)
    {
        /** @var Tag[] $tagsInDB */
        $tagsInDB = $this->findBy(['tagName' => $tagNameArray]);
        $tagNamesInDB = [];
        foreach ($tagsInDB as $tag) {
            $tagNamesInDB[] = $tag->getTagName();
        }
        $newTagNames = array_diff($tagNameArray, $tagNamesInDB);
        $resultTagArray = $tagsInDB;
        foreach ($newTagNames as $newTagName) {
            $newTag = new Tag();
            $newTag->setTagName($newTagName);
            $resultTagArray[] = $newTag;
        }
        return $resultTagArray;
    }
}
