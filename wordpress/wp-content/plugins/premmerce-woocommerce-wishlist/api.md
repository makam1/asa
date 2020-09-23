## Wishlist structure

```php
  $wishlist = [
    'ID'
    'user_id'
    'name'
    'wishlist_key'
    'products'
  ];
 ``` 

## API Url's

##### Create POST:
 
Get URL:
```php
...
site_url('wp-json/[route]')
...
```
Add to form : 
```php
...
wp_nonce_field('wp_rest');
...
```

##### Create GET:
 
Get URL:
```php
...
wp_nonce_url(site_url('wp-json/[route]/') . [parameters], 'wp_rest');
...
```


##### Routes list:
* POST: 'premmerce/wishlist/add' - додає продукт до вішліста і створює вішліст.
                
    Передати змінні: "wishlist_product_id" (айді продукту) та "wishlist_variation_id" (айді варіанту)

    Якщо була передана змінна "wishlist_id" (айді вішліста) товар буде доданний до цього вішліста (використовується коли є список вішлістів).
     
    Повертає: якщо ajax - массив ['success' => true|false] , чи робить редирект на сторінку 

* GET: 'premmerce/wishlist/add/popup' - повертає форму зі списком вішлістів для вибору, чи створення нового

    Передати змінні: "wishlist_product_id" (айді продукту) та "wishlist_variation_id" (айді варіанту)
    
    Повертає: ['success' => true|false, 'html' => ...]
    html - це файл wishlist-popup.php. В який передаються змінні "productId" (айді товару який додається до вішліста) і "wishlists" (список всіх вішлістів користувача)

* POST: 'premmerce/wishlist/page' - обробляє екшени вішліста, такі як 'rename' і 'move'.

    Передати змінні Rename: "wishlist_name" (нове ім’я вішліста), "wishlist_key" (ключ вішліста, для якого змінюємо ім’я)
    Передати змінні Move: "wishlist_key" (ключ вішліста з якого переносимо товар), "wishlist_move_to" (ключ вішліста, в який переносимо товар), "product_ids" (массив айдішок продуктів які будуть перенесені)
    
    Повертає: якщо ajax - массив ['success' => true|false] , чи робить редирект на сторінку
    
* GET: 'premmerce/wishlist/page/page/rename/(?P<wishlistKey>[a-zA-Z0-9]{13})' - повертає форму з полем для переіменовування
    
    Передати змінні: "wishlistKey" (ключ вішліста який треба переіменувати)

* GET: 'premmerce/wishlist/delete/(?P<wishlistKey>[a-zA-Z0-9]{13})' - видаляє вішліст
 
    Передати змінні: "wishlistKey" (ключ вішліста який треба видалити)
    
    Повертає: якщо ajax - массив ['success' => true|false] , чи робить редирект на сторінку
 
* GET: 'premmerce/wishlist/delete/(?P<wishlistKey>[a-zA-Z0-9]{13})/(?P<productId>\d+)' - видаляє продукт з вішліста
 
    Передати змінні: "wishlistKey" (ключ вішліста з якого треба видалити товар), "productId" (айді продукту який треба видалити з вішліста)
    
    Повертає: якщо ajax - массив ['success' => true|false] , чи робить редирект на сторінку
 
## Variables

##### wishlist-page

* $wishlists (array) - list of all wishlists.
```html
<?php foreach ($wishlist as $wl): ?>
    ...
<?php endforeach ?>
```
* wishlistsList (array) - list of wishlist for select
```html
<select name="wishlist_move_to">
    <?php foreach ($wishlistSelect as $key => $name): ?>
        <option value="<?php echo $key; ?>"><?php echo $name; ?></option>
    <?php endforeach; ?>
</select>
```
* $onlyView (bool) - user can just view wishlist
```html
<?php if (!$onlyView): ?>
    ...
<?php endif; ?>
```

##### wishlist-btn

* $url (str) - get url for add product to wishlist __site_url('wp-json/premmerce/wishlist/add')__
* $productId (int) - get corrent product id

##### wishlist-popup

* $productId (int) - selected product or variant id
* $wishlistsAll (array) - list of all wishlists

## Tpl

##### wishlist-btn.php

Кнопка яка додає до вішліста. Виводить чи кнопку "додати" чи "вже у вішлісті".

    Змінні:
    'url' => урл для сабміту форми,
    'productId' => айді продукту на якому рендерится кнопка,
    'inWishlist' => булєан значення яке повертає чи присутній цей продукт в якомусь вішлісті,

##### wishlist-page.php

Сама сторінка на фронті, з обмеженними можливостями.

    Змінні:
    'wishlists' => список всіх вішлістів,
    'wishlistsList' => список вішлістів, виводиться в селекті,
    'onlyView' => перевірка чи може данний користувач редагувати вішліст,
    'showMove' => перевірка чи можна переносити товар,
    'apiUrlWishListPage' => урл для контролю сторінкою,
    'apiUrlWishListDelete' => урл для видалення вішліста чи товару,

Додано два хуки, для виводу додаткової інформації в хедер вішліста. 

    premmerce_wishlist_page_before_header_fields
    premmerce_wishlist_page_after_header_fields

Передає дві змінні:
    
    $wishlist - поточний вішліст
    $onlyView - чи поточний користувач може лише переглядати вішліст

##### wishlist-page-full.php

Сама сторінка на фронті, з максимальними можливостями роботи з вішлістами.

    Змінні:
    'wishlists' => список всіх вішлістів,
    'wishlistsList' => список вішлістів, виводиться в селекті,
    'onlyView' => перевірка чи може данний користувач редагувати вішліст,
    'showMove' => перевірка чи можна переносити товар,
    'apiUrlWishListPage' => урл для контролю сторінкою,
    'apiUrlWishListDelete' => урл для видалення вішліста чи товару,

##### wishlist-popup.php

Форма зі списком вішлістів.

    Змінні:
    'productId' => айді продукту який додається до вішлісту,
    'wishlists' => список всіх вішлістів,