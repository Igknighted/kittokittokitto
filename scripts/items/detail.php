<?php
/**
 *  
 **/

switch($_REQUEST['state'])
{
    default:
    {
        $ERRORS = array();
        $id = stripinput($_REQUEST['item']['id']);

        $item = Item::factory($id,$db);
        if($item == null)
        {
            $ERRORS[] = 'Invalid item ID specified.';
        }
        else
        {
            if($item->getUserId() != $User->getUserId())
            {
                $ERRORS[] = 'This is not your item.';
            }
        } // end item exists

        if(sizeof($ERRORS) > 0)
        {
            draw_errors($ERRORS);
        } 
        else
        {
            $DISPLAY = array(
                'id' => $item->getUserItemId(),
                'name' => $item->getItemName(),
                'description' => $item->getItemDescr(),
                'actions' => array(
                    '' => 'Select one...',
                    'use' => 'Use',
                    'give' => 'Give',
                    'destroy' => 'Destroy',
                ),
            );

            $renderer->assign('item',$DISPLAY);
            $renderer->display('items/details.tpl');
        } // end show item

        break;
    } // end default

    case 'action':
    {
        $ERRORS = array();
        $id = stripinput($_REQUEST['action']['item_id']);

        $item = Item::factory($id,$db);
        if($item == null)
        {
            $ERRORS[] = 'Invalid item ID specified.';
        }
        else
        {
            if($item->getUserId() != $User->getUserId())
            {
                $ERRORS[] = 'This is not your item.';
            }
        } // end item exists

        if(sizeof($ERRORS) > 0)
        {
            draw_errors($ERRORS);
        } 
        else
        {
            // Determine what action is to be taken.
            switch($_REQUEST['action']['type'])
            {
                case 'give':
                {
                    $renderer->assign('item_name',$item->getItemName());
                    $renderer->assign('item_id',$item->getUserItemId());
                    $renderer->display('items/give_form.tpl');
                
                    break;
                } // end give
                
                case 'destroy':
                {
                    $item->destroy();
                    $_SESSION['item_notice'] = "You have destroyed <strong>{$item->getItemName()}</strong>.";

                    redirect('items');

                    break;
                } // end destroy
                
                case 'use':
                {
                    $PET_LIST = array();
                    $ITEM = array(
                        'id' => $item->getUserItemId(),
                        'name' => $item->getItemName(),
                    );
                    
                    $pets = $User->grabPets();
                    foreach($pets as $pet)
                    {
                        $PET_LIST[$pet->getUserPetId()] = $pet->getPetName();
                    } // end pets loop
                  
                    if(sizeof($PET_LIST) == 0)
                    {
                        draw_errors('You do not have a pet to use this item on.');
                    }
                    else
                    {
                        $renderer->assign('use_verb',$item->getVerb()); 
                        $renderer->assign('pets',$PET_LIST);
                        $renderer->assign('item',$ITEM);
                        $renderer->display('items/use_form.tpl');
                    }

                    break;
                } // end use

                default:
                {
                    draw_errors('You forgot to pick an action!');
                    
                    break;
                } // end default
            } // end action switch
        } // end no errors

        break;
    } // end action

    // Process page for 'use' after pet has been selected.
    case 'use_item':
    {
        $ERRORS = array();
        $id = stripinput($_POST['use']['item_id']);
        $pet_id = stripinput($_POST['use']['pet_id']);

        $item = Item::factory($id,$db);
        if($item == null)
        {
            $ERRORS[] = 'Invalid item ID specified.';
        }
        else
        {
            if($item->getUserId() != $User->getUserId())
            {
                $ERRORS[] = 'This is not your item.';
            }
        } // end item exists

        // Verify the pet.
        $pet = new Pet($db);
        $pet = $pet->findOneByUserPetId($pet_id);

        if($pet == null)
        {
            $ERRORS[] = 'Invalid pet specified.';
        }
        else
        {
            if($User->getUserId() != $pet->getUserId())
            {
                $ERRORS[] = 'This is not your pet.';
            }
        } // end pet found

        if(sizeof($ERRORS) > 0)
        {
            draw_errors($ERRORS);
        } // end errors
        else
        {
            // To add a new item type, add the appropriate entry to 
            // item_class, define that class (use Food_Item as an example!)
            // and add a call to it's action method with the appropriate
            // parameters here.
            switch(get_class($item))
            {
                case 'Food_Item':
                {
                    $_SESSION['item_notice'] = $item->feedTo($pet); 
                    redirect('items');
                    
                    break;
                } // end Food_Item

                case 'Toy_Item':
                {
                    $_SESSION['item_notice'] = $item->playWith($pet); 
                    redirect('items');

                    break;
                } // end Food_Item

                case 'Paint_Item':
                {
                    $_SESSION['item_notice'] = $item->paint($pet);
                    redirect('items');
                    
                    break;
                } // end Food_Item
                
                default:
                {
                    draw_errors('System error - item is of an unknown type.');
                    
                    break;   
                } // end default

            } // end item type switch
        } // end no errors

        break;
    } // end use_item

    case 'give_process':
    {
        $ERRORS = array();
        $id = stripinput($_REQUEST['give']['item_id']);
        $other_user_name = stripinput($_REQUEST['give']['username']);

        $item = Item::factory($id,$db);
        if($item == null)
        {
            $ERRORS[] = 'Invalid item ID specified.';
        }
        else
        {
            if($item->getUserId() != $User->getUserId())
            {
                $ERRORS[] = 'This is not your item.';
            }
        } // end item exists

        // Verify the other user is real lolzu.
        $other_user = new User($db);
        $other_user = $other_user->findOneByUserName($other_user_name);

        if($other_user == null)
        {
            $ERRORS[] = 'Invalid user specified.';
        }

        if(sizeof($ERRORS) > 0)
        {
            draw_errors($ERRORS);
        } 
        else
        {
            $item->giveItem($other_user->getUserId());
            $_SESSION['item_notice'] = "You have given <strong>{$item->getItemName()}</strong> to {$other_user->getUserName()}.";
            
            redirect('items');
        } // end DO IT
        
        break;
    } // end give_process
} // end switch

?>
