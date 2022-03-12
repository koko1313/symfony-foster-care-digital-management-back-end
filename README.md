[Front-end project](https://github.com/koko1313/react-social-care-digital-management-front-end)

# Приемна грижа - мениджмънт


### Какво представлява “Приемна грижа”
**Националната асоциация за приемна грижа** е създадена от приемни родители в България.  

Тя цели да осигури временна грижа за деца в риск, като целта е децата да бъдат 
отглеждани в условията на сигурна, подкрепяща и стимулираща семейна среда.  

В периода на настаняването, приемното семейство и детето получават съдействие и подкрепа 
от страна на социалните работници от отдел “Закрила на детето” и от доставчици на 
социални услуги.  

Официална страница на Национална асоциация за приемна грижа: [https://www.napg.eu/](https://www.napg.eu/)


### Какво представлява проекта “Приемна грижа - мениджмънт”
“Приемна грижа - мениджмънт” е онлайн базирана система за менажиране, организиране, 
подреждане и споделяне на информация между различни звена и организации, 
работещи по един проект *(Национална асоциация за приемна грижа)*, но намиращи се 
на различни места в България.  

Целта на системата е да избегне използването на хартиените документи и да 
подпомогне и облекчи административната работа на служителите, работещи за 
Националната асоциация за приемна грижа. 

Всеки потребител (служител) достъпва системата със собствен акаунт, чрез който 
получава съответните права и нива на достъп до различните функционалности.  

Някои от основните характеристики на описаното приложение са:
- Наличие на интерактивен и интуитивен интерфейс;
- Responsive дизайн, правещ приложението да изглежда добре както на настолен компютър, така и на мобилни устройства;
- Бързина и удобство при работа със системата.  

Уеб приложението е със семпъл дизайн, допринасящ за лесното използване на системата.
До момента няма изградена подобна система и цялата административна работа се изпълнява посредством хартиени документи, които отделните звена си споделят чрез сканиране и изпращане под формата на e-mail съобщения.


### Как се инсталира
1. `composer install`
2. `create the database (name: foster-care)`
3.  ```
    php bin/console doctrine:migrations:migrate
    php bin/console doctrine:fixtures:load
    symfony serve
    ```


### Used packages
- [cors-bundle](https://packagist.org/packages/nelmio/cors-bundle)
- [dompdf](https://packagist.org/packages/dompdf/dompdf)
- [twig-bundle](https://packagist.org/packages/symfony/twig-bundle)
- [jms/serializer-bundle](https://packagist.org/packages/jms/serializer-bundle)
