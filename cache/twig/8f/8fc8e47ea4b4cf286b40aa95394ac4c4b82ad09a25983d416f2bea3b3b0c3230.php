<?php

/* test/test.twig */
class __TwigTemplate_56f181c40945fdfbf5e92591703ec695984a88092a0744edc3aa14eedff3baaf extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<html>
<head>

</head>
<body>
    <h1>";
        // line 6
        echo twig_escape_filter($this->env, ($context["data"] ?? null), "html", null, true);
        echo "</h1>
    ";
        // line 7
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["test"] ?? null));
        foreach ($context['_seq'] as $context["key"] => $context["val"]) {
            // line 8
            echo "        <h4>";
            echo twig_escape_filter($this->env, $context["key"], "html", null, true);
            echo "=====>";
            echo twig_escape_filter($this->env, $context["val"], "html", null, true);
            echo "</h4>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['key'], $context['val'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 10
        echo "</body>
</html>";
    }

    public function getTemplateName()
    {
        return "test/test.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  49 => 10,  38 => 8,  34 => 7,  30 => 6,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("<html>
<head>

</head>
<body>
    <h1>{{ data }}</h1>
    {% for key,val in test %}
        <h4>{{ key }}=====>{{ val }}</h4>
    {% endfor %}
</body>
</html>", "test/test.twig", "/data/webroot/LjfPHP/app/views/test/test.twig");
    }
}
