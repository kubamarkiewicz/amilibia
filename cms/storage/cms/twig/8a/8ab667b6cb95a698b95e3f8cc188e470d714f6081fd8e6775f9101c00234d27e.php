<?php

/* /Users/kubamarkiewicz/work projects/2017/amilibia/www/cms/themes/kuba/layouts/kuba.htm */
class __TwigTemplate_f958fb156755f6a41b64a8e75289baecb02abcaa0995f4c102aa5f10b1f11016 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "hagha 
";
        // line 2
        echo call_user_func_array($this->env->getFilter('_')->getCallable(), array("translate me"));
        echo "




";
        // line 7
        echo $this->env->getExtension('CMS')->pageFunction();
        // line 8
        echo "
<h3>Ordering information</h3>

            ";
        // line 11
        $context['__placeholder_ordering_default_contents'] = null;        echo $this->env->getExtension('CMS')->displayBlock('ordering', $context['__placeholder_ordering_default_contents']);
        unset($context['__placeholder_ordering_default_contents']);    }

    public function getTemplateName()
    {
        return "/Users/kubamarkiewicz/work projects/2017/amilibia/www/cms/themes/kuba/layouts/kuba.htm";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  37 => 11,  32 => 8,  30 => 7,  22 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("hagha 
{{ 'translate me'|_ }}




{% page %}

<h3>Ordering information</h3>

            {% placeholder ordering title=\"Ordering\" %}", "/Users/kubamarkiewicz/work projects/2017/amilibia/www/cms/themes/kuba/layouts/kuba.htm", "");
    }
}
