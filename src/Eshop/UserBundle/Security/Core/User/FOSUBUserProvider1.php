<?php
namespace EspritBundle\Security\Core\User;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseClass;
use Symfony\Component\Security\Core\User\UserInterface;

class FOSUBUserProvider extends BaseClass
{
    /**
     * {@inheritDoc}
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        $property = $this->getProperty($response);
        $username = $response->getUsername();
 
        $service = $response->getResourceOwner()->getName();
        $setter = 'set'.ucfirst($service);
        $setter_id = $setter.'Id';
        $setter_token = $setter.'AccessToken';
        //we "disconnect" previously connected users
        if (null !== $previousUser = $this->userManager->findUserBy(array($property => $username))) {
            $previousUser->$setter_id(null);
            $previousUser->$setter_token(null);
            $this->userManager->updateUser($previousUser);
        }
        //we connect current user
        $user->$setter_id($username);
        $user->$setter_token($response->getAccessToken());
        $this->userManager->updateUser($user);
    }
    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $username = $response->getUsername();
      
       
  
            $username=$response->getEmail ();
        $user = $this->userManager->findUserBy(array("username" => $username));
     
        //when the user is registrating
        if ($user === null) {
            $service = $response->getResourceOwner()->getName();
            $setter = 'set'.ucfirst($service);
            $setter_id = $setter.'Id';
            $setter_token = $setter.'AccessToken';
            // create new user here
            $user = $this->userManager->createUser();
           // $user->$setter_id($response);
            $user->$setter_token($response->getAccessToken());
            //I have set all requested data with the user's username
            //modify here with relevant data
            $user->setUsername($username);
            $user->setEmail($response->getEmail());
            $user->setPlainPassword($username);
            $user->setNom($response->getLastName());
            $user->setPrenom($response->getFirstName());
            $user->setEnabled(true);
            $user->setRoles(array('ROLE_CLIENT'));
                
 
            $this->userManager->updateUser($user);
//             $em=$this->getDoctrine()->getManager();
//             $user2=$em->getRepository('TunisiaMallTMBundle:User')->findOneBy(array("username"=>$username));
//                user2
//                  $em->persist($panier);
//                 $em->flush();
            
            return $user;
            
        }
        $this->userManager->updateUser($user);
        //if user exists - go with the HWIOAuth way
//        $user = parent::loadUserByOAuthUserResponse($response);
//        $serviceName = $response->getResourceOwner()->getName();
//        $setter = 'set' . ucfirst($serviceName) . 'AccessToken';
//        //update access token
//        $user->$setter($response->getAccessToken());
        return $user;
    }
}