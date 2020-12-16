<?php
echo "Task 5 <br>";
class A {
    public function foo() {
        static $x = 0;
        echo ++$x;
    }
}
$a1 = new A();
$a2 = new A();
echo $a1->foo();
echo $a2->foo();
echo $a1->foo();
echo $a2->foo();
//1234
//На каждом шаге число будет увеличиваться перед выводом
//так как стоит префиксный инкремент
//Из-за того, что переменная "статична", она будет увеличиваться
//независимо он объетов, тк она общая для всех и
//не удет переопределена при повторном запуске
echo "<hr>";
echo "Task 6 <br>";
class C {
    public function foo() {
        static $x = 0;
        echo ++$x;
    }
}
class B extends C {
}
$a1 = new C();
$b1 = new B();
echo $a1->foo();
echo $b1->foo();
echo $a1->foo();
echo $b1->foo();
echo "<hr>";
//1122
//Статичная переменная относится только к своему экземпляру класса
//тоесть ко всем объектам отдельного класса
echo "Task 7 <br>";
class D {
    public function foo() {
        static $x = 0;
        echo ++$x;
    }
}
class E extends D {
}
$a1 = new D;
$b1 = new E;
$a1->foo();
$b1->foo();
$a1->foo();
$b1->foo();
//1122
//Аналогично предыдущему заданию
//Нет пустых скобок, но нет и переменных
//так как нет конструктора, потому можно опустить