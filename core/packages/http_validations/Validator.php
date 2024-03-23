<?php

namespace src;

require_once __DIR__ . '/src/Validation.php';
require_once __DIR__ . '/src/Traits/MessagesTrait.php';
require_once __DIR__ . '/src/Rules/Required.php';
require_once __DIR__ . '/src/Rules/Min.php';
require_once __DIR__ . '/src/Rules/Max.php';
require_once __DIR__ . '/src/Rules/Email.php';
require_once __DIR__ . '/src/Rules/Unique.php';
require_once __DIR__ . '/src/Rules/URL.php';
require_once __DIR__ . '/src/Rules/Numeric.php';
require_once __DIR__ . '/src/Rules/SpecialCharacters.php';
require_once __DIR__ . '/src/RuleNotFoundException.php';

class Validator
{
    use Traits\MessagesTrait;

    /** @var array */
    protected $translations = [];

    /** @var array */
    protected $validators = [];

    /** @var bool */
    protected $allowRuleOverride = false;

    /** @var bool */
    protected $useHumanizedKeys = true;

    /**
     * Constructor
     *
     * @param array $messages
     * @return void
     */
    public function __construct(array $messages = [])
    {
        $this->messages = $messages;
        $this->registerBaseValidators();
    }

    /**
     * Register or override existing validator
     *
     * @param mixed $key
     * @param $rule
     * @return void
     */
    public function setValidator(string $key, Rule $rule)
    {
        $this->validators[$key] = $rule;
        $rule->setKey($key);
    }

    /**
     * Get validator object from given $key
     *
     * @param mixed $key
     * @return mixed
     */
    public function getValidator($key)
    {
        return isset($this->validators[$key]) ? $this->validators[$key] : null;
    }

    /**
     * Validate $inputs
     *
     * @param array $inputs
     * @param array $rules
     * @param array $messages
     * @return Validation
     */
    public function validate(array $inputs, array $rules, array $messages = []): Validation
    {
        $validation = $this->make($inputs, $rules, $messages);
        $validation->validate();
        return $validation;
    }

    /**
     * Given $inputs, $rules and $messages to make the Validation class instance
     *
     * @param array $inputs
     * @param array $rules
     * @param array $messages
     * @return Validation
     */
    public function make(array $inputs, array $rules, array $messages = []): Validation
    {
        $messages = array_merge($this->messages, $messages);
        $validation = new Validation($this, $inputs, $rules, $messages);

        return $validation;
    }

    /**
     * Magic invoke method to make Rule instance
     *
     * @param string $rule
     * @return Rule
     * @throws RuleNotFoundException
     */
    public function __invoke(string $rule): Rule
    {
        $args = func_get_args();
        $rule = array_shift($args);
        $params = $args;
        $validator = $this->getValidator($rule);
        if (!$validator) {
            throw new RuleNotFoundException("Validator '{$rule}' is not registered", 1);
        }

        $clonedValidator = clone $validator;
        $clonedValidator->fillParameters($params);

        return $clonedValidator;
    }

    /**
     * Initialize base validators array
     *
     * @return void
     */
    protected function registerBaseValidators()
    {
        $baseValidator = [
            'required' => new Rules\Required,
            'email' => new Rules\Email,
            'unique' => new Rules\Unique,
            'min' => new Rules\Min,
            'max' => new Rules\Max,
            'validURL' => new Rules\URL,
            'numeric' => new Rules\Numeric,
            'specialCharacters' => new Rules\SpecialCharacters,
        ];

        foreach ($baseValidator as $key => $validator) {
            $this->setValidator($key, $validator);
        }
    }

    /**
     * Given $ruleName and $rule to add new validator
     *
     * @param string $ruleName
     * @param \src\Rule $rule
     * @return void
     */
    public function addValidator(string $ruleName, Rule $rule)
    {
        if (!$this->allowRuleOverride && array_key_exists($ruleName, $this->validators)) {
            throw new RuleQuashException(
                "You cannot override a built in rule. You have to rename your rule"
            );
        }

        $this->setValidator($ruleName, $rule);
    }

    /**
     * Set rule can allow to be overrided
     *
     * @param boolean $status
     * @return void
     */
    public function allowRuleOverride(bool $status = false)
    {
        $this->allowRuleOverride = $status;
    }

    /**
     * Set this can use humanize keys
     *
     * @param boolean $useHumanizedKeys
     * @return void
     */
    public function setUseHumanizedKeys(bool $useHumanizedKeys = true)
    {
        $this->useHumanizedKeys = $useHumanizedKeys;
    }

    /**
     * Get $this->useHumanizedKeys value
     *
     * @return void
     */
    public function isUsingHumanizedKey(): bool
    {
        return $this->useHumanizedKeys;
    }
}
