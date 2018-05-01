<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Setting
 *
 * @ORM\Table(name="setting")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SettingRepository")
 */
class Setting
{
	use ORMBehaviors\Loggable\Loggable;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=255, nullable=true)
     */
    private $label;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="value", type="string", length=255, nullable=true)
     */
    private $value;

    /**
     * @var string|null
     *
     * @ORM\Column(name="note", type="text", nullable=true)
     */
    private $note;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set label.
     *
     * @param string $label
     *
     * @return Setting
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Setting
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set value.
     *
     * @param string|null $value
     *
     * @return Setting
     */
    public function setValue($value = null)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value.
     *
     * @return string|null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set note.
     *
     * @param string|null $note
     *
     * @return Setting
     */
    public function setNote($note = null)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note.
     *
     * @return string|null
     */
    public function getNote()
    {
        return $this->note;
    }

    public function getUpdateLogMessage( array $changeSets = [] ) {
	    $message = [];
	    foreach ($changeSets as $property => $changeSet) {
		    for ($i = 0, $s = sizeof($changeSet); $i < $s; $i++) {
			    if ($changeSet[$i] instanceof \DateTime) {
				    $changeSet[$i] = $changeSet[$i]->format("Y-m-d H:i:s.u");
			    }
		    }

		    if ($changeSet[0] != $changeSet[1]) {
			    $message[] = sprintf(
				    '%s#%s : property "%s" changed from "%s" to "%s"',
				    __CLASS__,
				    $this->getName(),
				    $property,
				    !is_array($changeSet[0]) ? $changeSet[0] : "an array",
				    !is_array($changeSet[1]) ? $changeSet[1] : "an array"
			    );
		    }
	    }

	    return implode("\n", $message);
    }
}
