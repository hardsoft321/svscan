# SuiteCRM Vulnerabilities Scanner

It is a wrapper for [progpilot](https://github.com/designsecurity/progpilot)
with additional rules for SuiteCRM.

It can find sql injections like this
```php
<?php
class SomeClass
{
    function method1()
    {
        $query = "update linked_docs set deleted=1 where id='" . $_POST['signed_id'] . "'";
        $this->db->query($query);
    }

    function method2()
    {
        global $focus;
        $focusId = $_REQUEST['record'];
        $where = "notes.parent_id='{$focusId}' AND notes.filename IS NOT NULL";
        $focus->get_full_list('', $where);
    }

}
```

Don't forget
```sh
composer install
```

Then run
```sh
php svscan.php /path/to/SuiteCRM/some-dir-or-file
```
or
```sh
cd /path/to/SuiteCRM/some-dir
/path/to/svscan.php
```
