<?php namespace App\Http\Controllers;

use Validator;
use Input;
use Crypt;
use Eloquent;
use Response;
use App\User;
use URL;
use Mail;
use Auth;
use Redirect;
use Config;
use Request;
use File;
use App\Employee;

class UsersController extends Controller {

    /*
    |--------------------------------------------------------------------------
    | AUTHOR: BORN0101CODE
    | USER MANAGEMENT STARTS HERE
    |--------------------------------------------------------------------------
    |
    */

    public function __construct()
    {
        $this->params = array(
            'error' => false,
            'redirect' => false,
            'redirect_to' => '/',
            'msg' => ''
        );

        $this->admins = array(
            'admin', 'hr', 'owners'
        );
    }

    public function create()
    {
        //if( Auth::check() )
            //return Redirect::to('event');

        $this->params['page_title'] = 'Sign Up';
        return view('employees.create', $this->params);
    }

    public function create_participant()
    {
        if( Auth::check() )
            return Redirect::to('/');

        $this->params['page_title'] = 'Sign Up';
        return view('users.participant.signup', $this->params);
    }

    public function store()
    {
        $rules = array(
            'user_firstname'    => 'required|min:2|max:50',
            'user_lastname'     => 'required|min:2|max:50',
            'user_email'        => 'required|email|unique:employees,email',
            'user_password'     => 'required|confirmed|min:5|max:20'
        );

        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            $messages = $validator->messages()->getMessages();
            $this->params['error'] = true;
            foreach ($messages as $field_name => $message) {
                $this->params['msg'] .= '<br/>'.$message[0];
            }
            return Response::json($this->params);
        } else {
            // store
            $hashed_password = Crypt::encrypt(Input::get('user_password'));

            $user_data = array(
                'user_confirmation_code' => sha1( uniqid().Input::get('user_email') ),
            );

            $user = new Employee;
            $user->firstname               = Input::get('user_firstname');
            $user->lastname                = Input::get('user_lastname');
            $user->email                   = Input::get('user_email');
            $user->password                = $hashed_password;
            $user->uid                     = sha1( uniqid().Input::get('user_name') );
            $user->type                    = in_array( Input::get('user_type'), array('participant','organizer') ) ? Input::get('user_type') : 'participant';
            $user->save();

            $this->params['error'] = false;
            $this->params['msg'] = 'Successfully registered! Please find confirmation link sent to your email.';

            $confirmation_link = URL::to('/confirm/'.$user->user_uid.'/'.$user_data['user_confirmation_code']);

            return Response::json($this->params);
        }
    }

    public function profile()
    {
        if ( !Auth::check() ) {
            // authentication failure! lets go back to the login page
            return Redirect::route('login')
                ->with('flash_error', 'Your session has expired please login again.');
        }

        $user = User::find( Auth::user()->id );

        $this->params['page_title'] = 'Profile';
        $this->params['user'] = $user;
        $this->params['user_data'] = json_decode($user->user_data);

        return view('users.profile', $this->params);
    }


    public function edit()
    {
        // Authentication failure! lets go back to the login page.
        if ( !Auth::check() ) {
            return Redirect::route('login')
                ->with('flash_error', 'Your session has expired please login again.');
        }

        $user = User::find( Auth::user()->id );

        if( $user ) {
            $this->params['page_title'] = 'Profile';
            $this->params['countries'] = Country::all();

            $this->params['user'] = $user;
            $this->params['user_data'] = json_decode($user->user_data);

            return view('users.edit-profile', $this->params);
        }

        return Redirect::route('notfound');
    }

    public function edit_password()
    {
        // Authentication failure! lets go back to the login page.
        if ( !Auth::check() ) {
            return Redirect::route('login')
                ->with('flash_error', 'Your session has expired please login again.');
        }

        $user = User::find( Auth::user()->id );

        if( $user ) {
            $this->params['page_title'] = 'Change Password';
            $this->params['user'] = $user;
            return view('users.edit-password', $this->params);
        }

        return Redirect::route('notfound');
    }

    public function edit_email()
    {
        // Authentication failure! lets go back to the login page.
        if ( !Auth::check() ) {
            return Redirect::route('login')
                ->with('flash_error', 'Your session has expired please login again.');
        }

        $user = User::find( Auth::user()->id );

        if( $user ) {
            $this->params['page_title'] = 'Change Email';
            $this->params['user'] = $user;
            return view('users.edit-email', $this->params);
        }

        return Redirect::route('notfound');
    }

    public function update_password()
    {
        // Authentication failure! lets go back to the login page
        if ( !Auth::check() ) {
            if ( Request::ajax() ) {
                $this->params['error'] = true;
                $this->params['redirect'] = true;
                $this->params['redirect_to'] = 'login';
                $this->params['msg'] = 'Your session has expired.';
                return Response::json($this->params);
            }
            return Redirect::route('login')
                ->with('flash_error', 'Your session has expired please login again.');
        }

        $user = User::find( Auth::user()->id );

        if( $user ) {
            $rules = array(
                'user_current_password'     => 'required|min:5|max:20',
                'user_new_password'         => 'required|confirmed|min:5|max:20',
            );

            $messages = array(
                'passcheck' => 'Your old password was incorrect',
            );

            $validator = Validator::make(Input::all(), $rules, $messages);

            if ( $validator->fails() ) {
                $messages = $validator->messages()->getMessages();
                $this->params['error'] = true;
                foreach ($messages as $field_name => $message) {
                    $this->params['msg'] .= '<br/>'.$message[0];
                }
                return Response::json($this->params);
            } else {
                // Check if current password matched with inputted password
                $user_current_password = Input::get('user_current_password');
                $decrypted_password = Crypt::decrypt($user->user_password);
                if( $decrypted_password !== $user_current_password ) {
                    $this->params['error'] = true;
                    $this->params['msg'] = "Old password was incorrect!";
                    //return Response::json($this->params);
                    return Redirect::to('edit/password')->with($this->params);
                }
                // Now update user password
                $user->user_password = Crypt::encrypt(Input::get('user_new_password'));
                $user->save();

                $this->params['redirect'] = false;
                $this->params['error'] = false;
                $this->params['msg'] = "Password successfully Updated!";
            }
            return Response::json($this->params);
            //return Redirect::to('edit/password')->with($this->params);
        }

        $this->params['redirect'] = true;
        $this->params['error'] = true;
        $this->params['redirect_to'] = 'login';
        $this->params['msg'] = "Unknown user!";
    }

    public function update_email()
    {
        // Authentication failure! lets go back to the login page
        if ( !Auth::check() ) {
            if ( Request::ajax() ) {
                $this->params['error'] = true;
                $this->params['redirect'] = true;
                $this->params['redirect_to'] = 'login';
                $this->params['msg'] = 'Your session has expired.';
                return Response::json($this->params);
            }
            return Redirect::route('login')
                ->with('flash_error', 'Your session has expired please login again.');
        }

        $user = User::find( Auth::user()->id );

        if( $user ) {
            $rules = array(
                'user_email'                => 'required|email|unique:users',
            );

            $validator = Validator::make(Input::all(), $rules);

            if ( $validator->fails() ) {
                $messages = $validator->messages()->getMessages();
                $this->params['error'] = true;
                foreach ($messages as $field_name => $message) {
                    $this->params['msg'] .= '<br/>'.$message[0];
                }
                return Response::json($this->params);
            }

            $user_data = json_decode( $user->user_data );
            $user_data->replace_email_with = Input::get('user_email');
            $user_data->user_new_email_confirmation = sha1( uniqid().$user_data->replace_email_with );


            Input::get('user_name', $user->user_name);

            $user->user_data = json_encode($user_data);

            $this->params['redirect'] = false;
            $this->params['error'] = false;
            $this->params['msg'] = "Successfully Updated! Please confirm email.";

            $confirmation_link = URL::to('/new_email_confirmation/'.$user->user_uid.'/'.$user_data->user_new_email_confirmation);

            $user->save();
            // Send confirmation link through email
            Mail::send('emails.users.change_email', array('firstname'=>$user->user_name, 'confirmation_link' => $confirmation_link), function($message) {
                $message->to(Input::get('user_email'), Input::get('user_name') )->subject('RaceIT Change Email Confirmation');
            });

            return Response::json($this->params);
        }

        if ( Request::ajax() ) {
            $this->params['redirect'] = true;
            $this->params['error'] = true;
            $this->params['redirect_to'] = 'login';
            $this->params['msg'] = "Unkwon user!";
            return Response::json($this->params);
        }

        return Redirect::route('login')
                ->with('flash_error', 'Unkwon user.');
    }

    public function update_profile()
    {
        // Authentication failure! lets go back to the login page
        if ( !Auth::check() ) {
            if ( Request::ajax() ) {
                $this->params['error'] = true;
                $this->params['redirect'] = true;
                $this->params['redirect_to'] = 'login';
                $this->params['msg'] = 'Your session has expired.';
                return Response::json($this->params);
            }
            return Redirect::route('login')
                ->with('flash_error', 'Your session has expired please login again.');
        }

        $user = User::find( Auth::user()->id );

        if( $user ) {
            $rules = array(
                'user_firstname' => 'required|min:2|max:50',
                'user_lastname'  => 'required|min:1|max:50',
                'user_birthdate' => 'required|min:9|max:11',
                'user_gender'    => 'required|min:4|max:6'
            );

            $userweb = Input::get('user_website');

            if($userweb) {
                $rules['user_website'] = 'min:9|max:63|url';
            }


            $validator = Validator::make(Input::all(), $rules);

            if ( $validator->fails() ) {
                $messages = $validator->messages()->getMessages();
                $this->params['error'] = true;
                foreach ($messages as $field_name => $message) {
                    $this->params['msg'] .= $message[0];
                }

            } else {
                $user->user_firstname   = Input::get('user_firstname');
                $user->user_lastname    = Input::get('user_lastname');
                $user->user_gender      = Input::get('user_gender');
                $user->user_phone       = Input::get('user_phone');
                $user->user_website     = Input::get('user_website');
                $user->user_birthdate   = date('Y-m-d', strtotime(Input::get('user_birthdate')) );
                $user->save();

                //$user->user_address = Input::get('user_address');
                //$user->user_birthdate = Input::get('user_birthdate');

                //$user->user_name = Input::get('user_name');
                // $user_data = array(
                //     'user_firstname'     => Input::get('user_firstname'),
                //     'user_lastname'      => Input::get('user_lastname'),
                //     'user_address'       => Input::get('user_address'),
                //     'user_city'          => Input::get('user_city'),
                //     'user_state'         => Input::get('user_state'),
                //     'country_id'         => Input::get('country_id'),
                // );
                //$user->user_data = json_encode($user_data);
                

                $this->params['msg'] = "Profile Successfully Updated!";
            }
            if ( Request::ajax() )
                return Response::json($this->params);
            else
                return Redirect::route('login')->with('flash_error', 'Your session has expired please login again.');
            //return Redirect::to('profile')->with($this->params);
        }
    }

    public function new_email_confirmation( $user_uid = null, $user_new_email_confirmation = null )
    {
        if( !$user_new_email_confirmation || !$user_uid )
            return Redirect::route('notfound');

        $user = User::whereRaw('user_uid = ? and user_status = \'ACTIVE\'', array($user_uid))->first();

        if( $user ) {
            $user_data = json_decode( $user->user_data );

            if( isset( $user_data->replace_email_with ) && $user_data->replace_email_with && $user_data->user_new_email_confirmation === $user_new_email_confirmation ) {
                $user->user_email = $user_data->replace_email_with;
                $user_data->replace_email_with = null;
                $user_data->user_new_email_confirmation = null;
                $user->user_data = json_encode($user_data);
                $user->update();
                //Logged user and redirect user to dashboard
                Auth::login($user);
                return Redirect::to('profile' )
                ->with('flash_notice', 'Your email has been successfully changed.');
            }
        }

        // Code invalid, must redirect to certain page.
        return Redirect::route('notfound');
    }

    public function confirm( $user_uid = null, $user_confirmation_code = null, $event_id = null, $product_id = null )
    {
        if( !$user_confirmation_code || !$user_uid )
            return Redirect::route('notfound');

        $user = User::whereRaw('user_uid = ? and user_status = \'UNCONFIRMED\'', array($user_uid))->first();

        if( $user ) {
            // Get user data and compare comfirmation code
            $user_data = json_decode( $user->user_data );
            if ( $user_data->user_confirmation_code === $user_confirmation_code ) {
                $user->user_status = 'ACTIVE';
                $user->update();
                //Logged user and redirect user to dashboard
                Auth::login($user);
                $this->params['error'] = false;
                $this->params['flash_notice'] = 'You\'ve successfully activated your account.';

                if( $user->user_type == 'organizer' )
                    return Redirect::to('event')->with($this->params);
                else if( $user->user_type == 'participant' ) {
                    $this->params['error'] = false;
                    $this->params['msg'] = 'You\'ve successfully activated your account.';
                    return Redirect::to('event/register/'.$event_id.'/'.$product_id)->with($this->params);
                } else
                    return Redirect::to('event')->with($this->params);

            }
        }

        // Code invalid, must redirect to certain page.
        return Redirect::to('/notfound');
    }

    public function google_login( $auth = null )
    {
        if( Input::has('code') ) {
            $code = Input::get('code');
            if( !$code ) {
                return Socialite::with('google')->redirect();
            }

            $google_user = Socialite::with('google')->user();

            // Save data here
            $user = User::whereRaw('user_email = ? and user_status = \'ACTIVE\'', array( $google_user->email ))->first();

            // If email address not found, signup user account
            if( !$user ) {
                // Now get data and insert into database
                $google_data = array(
                    'id' => $google_user->id,
                    'name' => $google_user->name,
                    'email' => $google_user->email,
                    'gender' => isset($google_user->user['gender']) ? $google_user->user['gender'] : '',
                    'tagline' => isset($google_user->user['tagline']) ? $google_user->user['tagline'] : '',
                    'occupation' => isset($google_user->user['occupation']) ? $google_user->user['occupation'] : '',
                );

                $user = new User;
                $user->user_name                    = $google_user->name;
                $user->user_email                   = $google_user->email;
                $user->user_status                  = 'ACTIVE';
                $user->user_type                    = 'organizer';
                $user->user_uid                     = uniqid();
                $user->user_data                    = json_encode(array('google_login' => true, 'google_signup' => true, 'goolgle_data' => $google_data));
                $user->save();

                //Logged user and redirect user to dashboard
                Auth::login($user);
                return Redirect::to('/dashboard/');
            } else {
                // Set user flag that the user has login with google
                $user_data = json_decode( $user->user_data );
                if( !$user_data )
                    $user_data = array(
                        'google_login' => true,
                    );
                else
                    $user_data->google_login = true;

                $user->user_data = json_encode($user_data);
                $user->save();

                //Logged user and redirect user to dashboard
                Auth::login($user);
                return Redirect::to('event');
            }
        }

        return Socialite::with('google')->redirect();


    }


    public function facebook_login( $auth = null )
    {
        if( Input::has('code') ) {
            $code = Input::get('code');
            if( !$code ) {
                return Socialite::with('facebook')->redirect();
            }

            $fb_user = Socialite::with('facebook')->user();

            // Save data here
            $user = User::whereRaw('user_email = ? and user_status = \'ACTIVE\'', array( $fb_user->email ))->first();

            // If email address not found, signup user account
            if( !$user ) {
                // Now get data and insert into database
                $facebook_data = array(
                    'id' => $fb_user->id,
                    'first_name' => $fb_user->user['first_name'],
                    'last_name' => $fb_user->user['last_name'],
                    'birthday' => isset($fb_user->user['birthday']) ? $fb_user->user['birthday'] : null,
                    'email' => $fb_user->email,
                    'gender' => isset($fb_user->user['gender']) ? $fb_user->user['gender'] : null,
                    'hometown' => isset($fb_user->user['hometown']) ? $fb_user->user['hometown'] : null,
                    'bio' => isset($fb_user->user['bio']) ? $fb_user->user['bio'] : null,
                );

                $user = new User;
                $user->user_firstname               = $fb_user->user['first_name'];
                $user->user_lastname                = $fb_user->user['last_name'];
                $user->user_email                   = $fb_user->email;
                $user->user_status                  = 'ACTIVE';
                $user->user_type                    = 'organizer';
                $user->user_uid                     = uniqid();
                $user->user_data                    = json_encode(array('facebook_login' => true, 'facebook_signup' => true, 'facebook_data' => $facebook_data));
                $user->save();

                //Logged user and redirect user to dashboard
                Auth::login($user);
                return Redirect::to('event');
            } else {
                // Set user flag that the user has login with google
                $user_data = json_decode( $user->user_data );
                if( !$user_data )
                    $user_data = array(
                        'facebook_login' => true,
                    );
                else
                    $user_data->facebook_login = true;

                $user->user_data = json_encode($user_data);
                $user->save();

                //Logged user and redirect user to dashboard
                Auth::login($user);
                return Redirect::to('event' );
            }
        }

        return Socialite::with('facebook')->redirect();
    }

    public function recover_password()
    {
        $this->params['page_title'] = 'Recover Password  -  RaceIT';
        return view('users.forgot_password', $this->params);
    }

    public function recover_password_submit()
    {
        $rules = array(
            'user_email'        => 'required|email',
        );
        $validator = Validator::make(Input::all(), $rules);

        //
        if ($validator->fails()) {
            $messages = $validator->messages()->getMessages();
            $this->params['error'] = true;
            foreach ($messages as $field_name => $message) {
                $this->params['msg'] .= '<br/>'.$message[0];
            }
            return Response::json($this->params);
        } else {
            // Check if email exist
            $user = User::whereRaw('user_email = ? and user_status = \'ACTIVE\'', array(Input::get('user_email')))->first()
;
            if( $user ) {

                $hashed_password = Crypt::encrypt(Input::get('user_password'));

                $user_data = json_decode( $user->user_data );

                
                $user_data->user_confirmation_code = sha1( uniqid().Input::get('user_password') );

                $confirmation_link = URL::to('/confirm/'.$user->user_uid.'/'.$user_data->user_confirmation_code);


                $this->params['msg'] = "Please recover password via email reset link.";

                $recovery_confirmation_link = URL::to('/forgot/password/recovery_confirmation/'.$user->user_uid.'/'.$user_data->user_confirmation_code);
                $user->user_data = json_encode( $user_data );
                $user->save();

                $mail_data = array(
                    'user' => $user,
                );
                // Send confirmation link through email
                Mail::send('emails.users.forgot_password', array('firstname'=>$user->user_name, 'recovery_confirmation_link' => $recovery_confirmation_link), function($message) use ($mail_data) {
                    $message->to( $mail_data['user']->user_email, $mail_data['user']->user_name)->subject('RaceIT Password Recovery');
                });

            } else {
                $this->params['error'] = true;
                $this->params['msg'] = "Email address not found.";
            }
        }

        return Response::json($this->params);
    }

    public function recovery_confirmation( $user_uid = null, $recovery_confirmation_link = null)
    {
        if( !$recovery_confirmation_link || !$user_uid )
            return Redirect::to('login')->with('flash_error', 'Password reset link is not valid!');

        $user = User::whereRaw('user_uid = ? and user_status = \'ACTIVE\'', array( $user_uid ))->first();
        if( !$user )
            return Redirect::to('login')->with('flash_error', 'Password reset link is not valid!');

        $this->params['user_uid'] = $user_uid;
        $this->params['user_password_reset_code'] = $recovery_confirmation_link;
        return view('users.forgot_new_password', $this->params);
    }

    public function new_password()
    {
        $rules = array(
            'user_password'     => 'required|confirmed|min:5|max:20',
            'reset_code'        => 'required|min:40|max:40',
            'user_uid'        => 'required|max:40',
        );
        $validator = Validator::make(Input::all(), $rules);

        // Fail validation
        if ($validator->fails()) {
            $messages = $validator->messages()->getMessages();
            $this->params['error'] = true;
            foreach ($messages as $field_name => $message) {
                $this->params['msg'] .= '<br/>'.$message[0];
            }
            return Response::json($this->params);
        }

        $user_uid = Input::get('user_uid');
        $reset_code = Input::get('reset_code');

        $user = User::whereRaw('user_uid = ? and user_status = \'ACTIVE\'', array( $user_uid ))->first();
        if( !$user ) {
            $this->params['error'] = true;
            $this->params['msg'] = "Password reset link is not valid.";
            return Response::json($this->params);
        }

        $user_data = json_decode($user->user_data);

        if( $user_data->user_confirmation_code !== $reset_code ) {
            $this->params['error'] = true;
            $this->params['msg'] = "Password reset link is not valid.";
            return Response::json($this->params);
        }

        $hashed_password = Crypt::encrypt(Input::get('user_password'));

        $user_data->user_confirmation_code = null;
        $user->user_password = $hashed_password;
        $user->user_data = json_encode( $user_data );
        $user->save();

        $this->params['error'] = false;
        $this->params['msg'] = "Password has been successfully changed.";
        return Response::json($this->params);
    }

    public function notfound()
    {
        return "User not found";
    }

}