<?php

class ParameterTest extends TestCase
{
    public function testListParameters()
    {
        $this->get('admin/parameter');
        $this->seeStatusCode(200);
        $this->seeJson([
            'enabled' => 1,
        ]);
    }

    public function testCreateParameter()
    {
        $name = 'Test_Parameter_'.date('Ymdhmisu');
        $data = [
            'name'        => $name,
            'description' => 'This is a sandbox parameter.',
            'enabled'     => true,
        ];
        $this->post('admin/parameter', $data);
        $this->seeStatusCode(200);
        $this->seeJson([
            'name' => $name,
         ]);
    }

    public function testShowParameter()
    {
        $parameter = \App\Parameter::first();
        $this->get('admin/parameter/'.$parameter->uuid);
        $this->seeStatusCode(200);
        $this->seeJsonContains([
            'name' => $parameter->name,
        ]);
    }

    public function testUpdateParameter()
    {
        $parameter = \App\Parameter::first();
        $name = $parameter->name;
        $parameter->name = $name.' Updated';
        $this->put('admin/parameter', $parameter->toArray());
        $this->seeStatusCode(422);

        $parameter->name = $name.'-Updated';
        $this->put('admin/parameter', $parameter->toArray());
        $this->seeStatusCode(200);
        $this->seeJson([
            'name' => $parameter->name,
         ]);
    }

    public function testEnableParameter()
    {
        $parameter = \App\Parameter::first();
        $this->put('admin/parameter/'.$parameter->uuid, $parameter->toArray());
        $this->seeStatusCode(200);
        $this->seeJson([
            'message' => true,
         ]);
    }

    public function testDisableParameter()
    {
        $parameter = \App\Parameter::first();
        $this->delete('admin/parameter/'.$parameter->uuid, $parameter->toArray());
        $this->seeStatusCode(200);
        $this->seeJson([
            'message' => true,
         ]);
    }

    public function testProcess()
    {
        // Todo: must be implemented before the controller and repository process method.
        $this->assertTrue(true);
    }
}
