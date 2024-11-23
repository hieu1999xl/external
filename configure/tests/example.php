<?php
/**
 * サンプルユニットテスト
 *
 * @author sakairi@liz-inc.co.jp
 */
class Test_Example extends TestCase
{
    /**
     * @test
     */
 	public function ENVの設定がTESTであること() {
        $this->assertEquals(Fuel::TEST, Fuel::$env);
    }
}
