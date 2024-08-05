<?require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$request = Bitrix\Main\Application::getInstance()->getContext()->getRequest();
global $USER;

function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

if(isset($request['TYPE'])) {
    if($request['TYPE'] == 'AUTH') {
        $arAuthResult = $USER->Login($request['EMAIL'], $request['PASSWORD'], "Y");

        if($arAuthResult['TYPE'] == 'ERROR') {
            echo json_encode([
                'SUCCESS' => false,
                'MESSAGE' => $arAuthResult['MESSAGE'],
            ]);
        } else {
            echo json_encode([
                'SUCCESS' => true,
                'REDIRECT' => '/personal/?success_auth=Y',
            ]);
        }
    }

    if($request['TYPE'] == 'REGISTER') {
        $arResult = $USER->Register($request['EMAIL'], $request['NAME'], "", $request['PASSWORD'], $request['CONFIRM_PASSWORD'], $request['EMAIL']);

        if($arResult['TYPE'] == 'ERROR') {
            echo json_encode([
                'SUCCESS' => false,
                'MESSAGE' => $arResult['MESSAGE'],
            ]);
        } else {
            CEvent::Send(
                "NEW_USER",
                's1',
                array(
                    "R_EMAIL" => $request['EMAIL'],
                    "R_NAME" => $request['NAME'],
                ),
                '',
                52
            );

            echo json_encode([
                'SUCCESS' => true,
                'REDIRECT' => '/personal/?success_reg=Y',
            ]);
        }
    }

    if($request['TYPE'] == 'FORGOT') {
        if(filter_var($request['EMAIL'], FILTER_VALIDATE_EMAIL)) {
            $rsUser = CUser::GetByLogin($request['EMAIL']);
            $arUser = $rsUser->Fetch();

            $newPassword = randomPassword();

            if(intval($arUser['ID'])) {
                $user = new CUser;
                $fields = Array(
                    "PASSWORD"          => $newPassword,
                    "CONFIRM_PASSWORD"  => $newPassword,
                );
                $user->Update(intval($arUser['ID']), $fields);

                CEvent::Send(
                    "USER_PASS_REQUEST",
                    's1',
                    array(
                        "R_EMAIL" => $request['EMAIL'],
                        "R_PASSWORD" => $newPassword,
                    ),
                    '',
                    53
                );

                echo json_encode([
                    'SUCCESS' => true,
                    'REDIRECT' => '/personal/forgot/?success=Y',
                ]);
            } else {
                echo json_encode([
                    'SUCCESS' => false,
                    'MESSAGE' => 'Попробуйте другой E-mail',
                ]);
            }
        } else {
            echo json_encode([
                'SUCCESS' => false,
                'MESSAGE' => 'Введите правильный E-mail',
            ]);
        }
    }

    if($request['TYPE'] == 'UPDATE' && $USER->IsAuthorized()) {
        if (filter_var($request['EMAIL'], FILTER_VALIDATE_EMAIL)) {
            $user = new CUser;
            $fields = Array(
                "EMAIL" => $request['EMAIL'],
                "NAME"  => $request['NAME'],
            );
            if($request['NEW_PASSWORD'] != '' && $request['CONFIRM_NEW_PASSWORD'] != '') {
                $fields['PASSWORD'] = $request['NEW_PASSWORD'];
                $fields['CONFIRM_PASSWORD'] = $request['CONFIRM_NEW_PASSWORD'];
            }
            $user->Update(intval($USER->GetID()), $fields);

            if($user->LAST_ERROR) {
                echo json_encode([
                    'SUCCESS' => false,
                    'MESSAGE' => $user->LAST_ERROR,
                ]);
            } else {
                echo json_encode([
                    'SUCCESS' => true,
                    'MESSAGE' => 'Данные успешно сохранены',
                ]);
            }
        } else {
            echo json_encode([
                'SUCCESS' => false,
                'MESSAGE' => 'E-mail указан неверно',
            ]);
        }
    }
}