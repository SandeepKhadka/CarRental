<?php

namespace App\Http\Controllers\MachineLearning;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SentimentController;
use App\Models\FakeReview;
use App\Models\Order;
use App\Models\ProductOrder;
use App\Models\ProductReview;
use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use UserInfo;
use Illuminate\Support\Str;
use Sentiment\Analyzer;



class FakeReviewDetectionController extends Controller
{
    public function checkReviewInfo($review)
    {
        $productKeywords = [
            "review" => ["product", "item", "purchase", "buy", "order", "merchandise"],
            "features" => ["size", "color", "weight", "dimensions", "material", "functionality"],
            "performance" => ["speed", "accuracy", "durability", "reliability"],
            "price" => ["affordability", "cost-effectiveness", "price-to-performance ratio"],
            "comparison" => ["strengths", "weaknesses", "similar products"],
            "user experience" => ["ease of use", "comfort", "convenience", "satisfaction"],
            "customer service" => ["responsiveness", "helpfulness", "professionalism"],
            "packaging" => ["quality", "shipping", "condition", "well-packaged"],
            "design" => ["aesthetic appeal", "style", "appearance"]
        ];

        $review = strtolower($review);

        $containsProductKeyword = false;

        foreach ($productKeywords as $category => $keywords) {
            foreach ($keywords as $keyword) {
                if (Str::contains($review, strtolower($keyword))) {
                    $containsProductKeyword = true;
                    break 2; // break out of both loops
                }
            }
        }
        if ($containsProductKeyword) {
            return 'genuine';
        } else {
            return 'fake';
        }
    }

    public function checkReviewSentiment($review)
    {
        $analyzer = new Analyzer();
        $sentiment = $analyzer->getSentiment($review);
        if ($sentiment['pos'] > $sentiment['neg'] && $sentiment['pos'] > $sentiment['neu']) {
            return "positive";
        } elseif ($sentiment['neg'] > $sentiment['pos'] && $sentiment['neg'] > $sentiment['neu']) {
            return "negative";
        } else {
            return "neutral";
        }
        // return $sentiment;
        // if ($sentiment > 0 && $sentiment != 1 ) {
        //     echo "The review is positive!";
        // } elseif ($sentiment < 0) {
        //     echo "The review is negative!";
        // } else {
        //     echo "The review is neutral.";
        // }
    }

    public function predict1(Request $request)
    {
        // dd($_SERVER['HTTP_USER_AGENT']);
        // dd(UserInfo::get_browser());
        // $user_agent = $_SERVER['HTTP_USER_AGENT'];
        // if (strpos($user_agent, 'Edg') !== false) {
        //     dd('Edge Browser');
        // } elseif (strpos($user_agent, 'Firefox') !== false) {
        //     echo 'User is using Firefox';
        // } elseif (strpos($user_agent, 'Safari') !== false) {
        //     echo 'User is using Safari';
        // } elseif (strpos($user_agent, 'Chrome') !== false) {
        //     echo 'User is using Chrome';
        // } elseif (strpos($user_agent, 'Opera') !== false) {
        //     echo 'User is using Opera';
        // } elseif (strpos($user_agent, 'IE') !== false) {
        //     echo 'User is using Internet Explorer';
        // } else {
        //     echo 'User is using an unknown browser';
        // }
        // dd("My browser is" . UserInfo::get_os());
        // dd($request->except('_token'));
        // dd($request->except('_token'));

        $client = new Client();
        $response = $client->request('POST', 'http://localhost:5000/predict', [
            'form_params' => $request->only(['rating', 'text_'])
        ]);

        $prediction = json_decode($response->getBody()->getContents(), true)['prediction'];

        $this->validate($request, [
            'rating' => 'required|numeric',
            'reason' => 'nullable|string',
            'text_' => 'nullable|string',
        ]);

        $user_info = [
            'ip_address' => UserInfo::get_ip(),
            'os' => UserInfo::get_os(),
            'browser' => UserInfo::get_browser(),
            'device' => UserInfo::get_device(),
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
        ];

        $number_of_same_user_info = UserInformation::where([
            'ip_address' => UserInfo::get_ip(),
            'os' => UserInfo::get_os(),
            'browser' => UserInfo::get_browser(),
            'device' => UserInfo::get_device(),
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
        ])->count();
        // dd($number_of_same_user_info);

        /**
         * To be a valid customer first check if the user has bought the product or not.
         * This can be done by creating history table for each user and fetch the data of each user.
         */

        // dd(analyzeSentiment($request->text_));
        $review_sentiment = $this->checkReviewSentiment($request->text_);
        $reviewInfo = $this->checkReviewInfo($request->text_);

        // dd(strval($valid_customer));
        // dd($prediction);

        // if ($prediction < str(0.5) || $number_of_same_user_info > 2 || strval($valid_customer) != $request->user_id) {
        // if($review_sentiment == 'positive' && $request->rating < 3 || $review_sentiment == 'negative' && $request->rating > 3)
        // if ($number_of_same_user_info > 1) {
        //     $data['review'] = $request->text_;
        //     $status = FakeReview::create($data);
        //     if ($status) {
        //         // $save_user_info = UserInformation::create($user_info);
        //         // if ($save_user_info) {
        //         return back()->with('success', 'Thank you for your feedback.');
        //         // } else {
        //         return back()->with('error', 'Something went wrong! Please try again.');
        //         // }
        //     } else {
        //         return back()->with('error', 'Something went wrong! Please try again.');
        //     }
        // } else 
        if ($prediction > str(0.9) || $reviewInfo == 'fake' || $number_of_same_user_info > 1 || $review_sentiment == 'positive' && $request->rating < 3 || $review_sentiment == 'negative' && $request->rating > 3) {
            // dd('This is fake');
            $data['review'] = $request->text_;
            $status = FakeReview::create($data);
            if ($status) {
                // $save_user_info = UserInformation::create($user_info);
                // if ($save_user_info) {
                return back()->with('success', 'Thank you for your feedback.');
                // } else {
                return back()->with('error', 'Something went wrong! Please try again.');
                // }
            } else {
                return back()->with('error', 'Something went wrong! Please try again.');
            }
        } else {
            // dd('This is genuine');
            $data = $request->except(['rating', 'text_', 'token_']);
            $data['rate'] = $request->rating;
            $data['review'] = $request->text_;
            $status = ProductReview::create($data);
            if ($status) {
                $save_user_info = UserInformation::create($user_info);
                if ($save_user_info) {
                    return back()->with('success', 'Thank you for your feedback.');
                } else {
                    return back()->with('error', 'Something went wrong! Please try again.');
                }
            } else {
                return back()->with('error', 'Something went wrong! Please try again.');
            }
        }
        // return view('prediction', compact('prediction'));
    }

    public function predict(Request $request)
    {
        // dd($_SERVER['HTTP_USER_AGENT']);
        // dd(UserInfo::get_browser());
        // $user_agent = $_SERVER['HTTP_USER_AGENT'];
        // if (strpos($user_agent, 'Edg') !== false) {
        //     dd('Edge Browser');
        // } elseif (strpos($user_agent, 'Firefox') !== false) {
        //     echo 'User is using Firefox';
        // } elseif (strpos($user_agent, 'Safari') !== false) {
        //     echo 'User is using Safari';
        // } elseif (strpos($user_agent, 'Chrome') !== false) {
        //     echo 'User is using Chrome';
        // } elseif (strpos($user_agent, 'Opera') !== false) {
        //     echo 'User is using Opera';
        // } elseif (strpos($user_agent, 'IE') !== false) {
        //     echo 'User is using Internet Explorer';
        // } else {
        //     echo 'User is using an unknown browser';
        // }
        // dd("My browser is" . UserInfo::get_os());
        // dd($request->except('_token'));
        // dd($request->except('_token'));

        $this->validate($request, [
            'rating' => 'required|numeric',
            'reason' => 'nullable|string',
            'text_' => 'nullable|string',
        ]);


        /**
         * To be a valid customer first check if the user has bought the product or not.
         * This can be done by creating history table for each user and fetch the data of each user.
         */


        // dd('This is genuine');
        $data = $request->except(['rating', 'text_', 'token_']);
        $data['rate'] = $request->rating;
        $data['review'] = $request->text_;
        $status = ProductReview::create($data);
        if ($status) {
            return back()->with('success', 'Thank you for your feedback.');
        } else {
            return back()->with('error', 'Something went wrong! Please try again.');
        }
        // return view('prediction', compact('prediction'));
    }
}
