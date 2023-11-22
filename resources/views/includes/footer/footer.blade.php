<footer>
    <div class="container footer-main-cont">
        <div class="footer-logo-cont">
            <a href="{{ route('home') }}" class="logo logo-ru">
                <svg viewBox="0 0 20 28"><use href="#logoSign" /></svg>
                <svg viewBox="0 0 155 26"><use href="#logoTitleRu" /></svg>
            </a>
        </div>
        <div class="footer-col-cont">
            <h5>Компания</h5>
            <ul class="footer-list">
                <li>
                    <a href="#">О компании</a>
                </li>
                <li>
                    <a href="#">Новости</a>
                </li>
                <li>
                    <a href="#">Партнёрам</a>
                </li>
                <li>
                    <a href="#">Вакансии</a>
                </li>
                <li>
                    <a href="#">Политика конфиденциальности</a>
                </li>
            </ul>
        </div>
        <div class="footer-col-cont">
            <h5>Покупателям</h5>
            <ul class="footer-list">
                <li>
                    <a href="#">Как оформить заказ</a>
                </li>
                <li>
                    <a href="#">Способы оплаты</a>
                </li>
                <li>
                    <a href="#">Кредиты</a>
                </li>
                <li>
                    <a href="#">Юридическим лицам</a>
                </li>
                <li>
                    <a href="#">Корпоративные отделы</a>
                </li>
            </ul>
        </div>
        <div class="footer-col-cont">
            <h5>Разное</h5>
            <ul class="footer-list">
                <li>
                    <a href="#">Доставка</a>
                </li>
                <li>
                    <a href="#">Обмен, возврат</a>
                </li>
                <li>
                    <a href="#">Подарочные карты</a>
                </li>
                <li>
                    <a href="#">Бонусная программа</a>
                </li>
                <li>
                    <a href="#">Помощь</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="container footer-copyright-cont">
        <hr />
        &copy; {{ date('Y') }} Это демонстрационный сайт
    </div>
</footer>