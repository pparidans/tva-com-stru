<?php

namespace spec\models;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StructuredCommunicationServiceSpec extends ObjectBehavior {

    function it_parse_a_vat_number_representation() {
    	$this->parse_vat("BE0507.722.348")->shouldReturn(507722348);
    }

    function it_format_a_vat_number_into_a_structured_communication() {
    	$this->format_vat_communication(507722348)->shouldReturn("050/7722/34801");
    }

    function it_format_a_vat_number_into_a_structured_communication_with_dash_separator() {
    	$this->format_vat_communication(507722348, "-")->shouldReturn("050-7722-34801");
    }

    function it_convert_a_vat_number_representation_into_structured_communication() {
    	$this->convert_vat("BE0507.722.348")->shouldReturn("050/7722/34801");
    }

}
