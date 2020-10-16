<?php

namespace App\Http\Controllers\Web\V1;

use App\Exceptions\Web\WebServiceExplainedException;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\WebBaseController;
use App\Http\Forms\Web\V1\AdvertisementWebForm;
use App\Http\Requests\Web\V1\AdvertisementCheckWebRequest;
use App\Http\Requests\Web\V1\AdvertisementWebRequest;
use App\Models\Entities\Advertisement;
use App\Services\Common\V1\Support\FileService;
use Illuminate\Http\Request;

class AdvertisementController extends WebBaseController
{
    protected $fileService;

    function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }
    public function index() {
        $advertisements = Advertisement::orderBy('created_at', 'desc')->get();
        return $this->adminPagesView('advertisement.index', compact('advertisements'));
    }

    public function create() {
        $advertisement_web_form = AdvertisementWebForm::inputGroups(null);
        return $this->adminPagesView('advertisement.create', compact('advertisement_web_form'));
    }

    public function store(AdvertisementWebRequest $request) {

        try {
            $path = $this->fileService->store($request->image, Advertisement::IMAGE_DIRECTORY);
            Advertisement::create([
                'link' => $request->link,
                'image_path' => $path,
                'product_id' => $request->product_id,
                'position' => $request->position
            ]);
        } catch (\Exception $exception) {

            if($path) $this->fileService->remove($path);
            throw new WebServiceExplainedException($exception->getMessage());
        }
        return redirect()->route('advertisement.index');
    }

    public function edit(AdvertisementCheckWebRequest $request) {
        $advertisement = Advertisement::find($request->id);
        $advertisement_web_form = AdvertisementWebForm::inputGroups($advertisement);
        return $this->adminPagesView('advertisement.edit', compact('advertisement', 'advertisement_web_form'));
    }

    public function update(AdvertisementWebRequest $request) {
        $advertisement = Advertisement::find($request->id);
        $old_path = $advertisement->image_path;
        try {
            if($request->image) {
                $path = $this->fileService->updateWithRemoveOrStore($request->image, Advertisement::IMAGE_DIRECTORY, $old_path);
                $old_path = $path;
            }
            $advertisement->update([
                'link' => $request->link,
                'position' => $request->position,
                'product_id' => $request->product_id,
                'image_path' => $old_path
            ]);
            $this->edited();
        } catch (\Exception $exception) {
            if($path) $this->fileService->remove($path);
            throw new WebServiceExplainedException($exception->getMessage());
        }

        return redirect()->route('advertisement.index');
    }

    public function delete(AdvertisementCheckWebRequest $request) {
        $advertisement = Advertisement::find($request->id);
        $advertisement->delete();
        $this->fileService->remove($advertisement->image_path);
        $this->deleted();
        return redirect()->route('advertisement.index');
    }
}
